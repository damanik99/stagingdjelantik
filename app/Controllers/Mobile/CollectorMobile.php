<?php

namespace App\Controllers\Mobile;

use App\Controllers\BaseController;
use App\Models\CollectionVisitAttachmentModel;
use App\Models\CollectionVisitModel;
use App\Models\ResidentModel;
use App\Models\UsersCollectionBalanceModel;
use App\Models\UsersCollectionDailySummaryModel;
use App\Models\UsersCollectionMonthlySummaryModel;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;
use Throwable;

class CollectorMobile extends BaseController
{
    private const DRAFT_SESSION_KEY = 'collect_oil';
    private const SUCCESS_SESSION_KEY = 'collect_oil_success_id';
    private const MAX_PHOTOS = 4;
    private const MAX_PHOTO_SIZE_KB = 2048;
    private const UNIT = 'LITER';

    protected UsersModel $usersModel;
    protected ResidentModel $residentModel;
    protected CollectionVisitModel $collectionVisitModel;
    protected CollectionVisitAttachmentModel $attachmentModel;
    protected UsersCollectionBalanceModel $usersBalanceModel;
    protected UsersCollectionDailySummaryModel $usersDailyModel;
    protected UsersCollectionMonthlySummaryModel $usersMonthlyModel;

    public function __construct()
    {
        $session = \Config\Services::session();

        if ($session->get('masuk') != true) {
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: ' . base_url('auth'));
            exit();
        }

        // Pastikan refresh pada halaman mobile tidak kehilangan program aktif.
        // Auth sudah mengisinya; fallback ini hanya memulihkan session yang
        // kosong dari relasi program user yang tersimpan di database.
        if (!$session->get('program') && $session->get('users_id')) {
            $db = \Config\Database::connect();
            $mobileProgram = $db->table('usersgroupprogram ugp')
                ->select('ugp.program_id, p.name')
                ->join('program p', 'p.program_id = ugp.program_id')
                ->where('ugp.users_id', (int) $session->get('users_id'))
                ->orderBy('p.created_date', 'ASC')
                ->get()->getRowArray();

            if ($mobileProgram) {
                $session->set([
                    'program' => (int) $mobileProgram['program_id'],
                    'nameprogram' => $mobileProgram['name'],
                ]);
            }
        }

        $this->usersModel = new UsersModel();
        $this->residentModel = new ResidentModel();
        $this->collectionVisitModel = new CollectionVisitModel();
        $this->attachmentModel = new CollectionVisitAttachmentModel();
        $this->usersBalanceModel = new UsersCollectionBalanceModel();
        $this->usersDailyModel = new UsersCollectionDailySummaryModel();
        $this->usersMonthlyModel = new UsersCollectionMonthlySummaryModel();
    }

    public function index()
    {
        return view('mobile/user/home');
    }

    public function collectOil()
    {
        return view('mobile/user/collectoil', [
            'residents' => $this->residentModel
                ->select('resident_id, resident_code, resident_name')
                ->where('active', 1)
                ->orderBy('created_date', 'DESC')
                ->findAll(20),
            'draft' => session()->get(self::DRAFT_SESSION_KEY) ?? [],
        ]);
    }

    public function searchResident()
    {
        $keyword = trim((string) $this->request->getGet('q'));
        $builder = $this->residentModel
            ->select('resident_id, resident_code, resident_name')
            ->where('active', 1);

        if ($keyword !== '') {
            $builder->groupStart()
                ->like('resident_name', $keyword)
                ->orLike('resident_code', $keyword)
                ->groupEnd();
        }

        return $this->response->setJSON([
            'success' => true,
            'residents' => $builder->orderBy('created_date', 'DESC')->findAll(20),
        ]);
    }

    public function saveResident()
    {
        $rules = [
            'resident_name' => 'required|max_length[150]',
            'phone' => 'required|max_length[30]',
            'address' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->jsonError('Data warga belum valid.', $this->validator->getErrors(), ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        $residentData = [
            'resident_code' => $this->generateUniqueNumber('resident', 'resident_code', 'RES'),
            'resident_name' => trim((string) $this->request->getPost('resident_name')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'address' => trim((string) $this->request->getPost('address')),
            'active' => 1,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => (int) session()->get('users_id'),
        ];

        if (!$this->residentModel->insert($residentData)) {
            return $this->jsonError('Gagal menyimpan warga.', $this->residentModel->errors(), ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        $residentData['resident_id'] = (int) $this->residentModel->getInsertID();

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Warga berhasil ditambahkan.',
            'resident' => [
                'resident_id' => $residentData['resident_id'],
                'resident_code' => $residentData['resident_code'],
                'resident_name' => $residentData['resident_name'],
            ],
            'csrf_hash' => csrf_hash(),
        ]);
    }

    public function quantityMobile()
    {
        $draft = session()->get(self::DRAFT_SESSION_KEY) ?? [];
        $residentId = (int) ($this->request->getGet('resident_id') ?: ($draft['resident_id'] ?? 0));
        $resident = $this->findActiveResident($residentId);

        if (!$resident) {
            session()->setFlashdata('error', 'Warga belum dipilih atau sudah tidak aktif.');
            return redirect()->to(base_url('mobile/user/collectoil'));
        }

        $draft['resident_id'] = $residentId;
        session()->set(self::DRAFT_SESSION_KEY, $draft);

        return view('mobile/user/quantity', ['resident' => $resident, 'draft' => $draft, 'unit' => self::UNIT]);
    }

    public function saveQuantity()
    {
        $rules = [
            'resident_id' => 'required|is_natural_no_zero',
            'qty' => 'required|decimal|greater_than[0]',
            'unit' => 'required|in_list[' . self::UNIT . ']',
        ];

        if (!$this->validate($rules)) {
            return $this->jsonError('Quantity belum valid.', $this->validator->getErrors(), ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        $residentId = (int) $this->request->getPost('resident_id');
        if (!$this->findActiveResident($residentId)) {
            return $this->jsonError('Data warga tidak ditemukan atau sudah tidak aktif.', [], ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        session()->set(self::DRAFT_SESSION_KEY, [
            'resident_id' => $residentId,
            'qty' => (float) $this->request->getPost('qty'),
            'unit' => self::UNIT,
        ]);

        return $this->response->setJSON([
            'success' => true,
            'redirect' => base_url('mobile/user/camera'),
            'csrf_hash' => csrf_hash(),
        ]);
    }

    public function camera()
    {
        $draft = session()->get(self::DRAFT_SESSION_KEY) ?? [];
        if (empty($draft['resident_id'])) {
            session()->setFlashdata('error', 'Warga belum dipilih.');
            return redirect()->to(base_url('mobile/user/collectoil'));
        }

        if (!isset($draft['qty']) || !is_numeric($draft['qty']) || (float) $draft['qty'] <= 0 || ($draft['unit'] ?? '') !== self::UNIT) {
            session()->setFlashdata('error', 'Quantity belum diisi atau tidak valid.');
            return redirect()->to(base_url('mobile/user/quantitymobile?resident_id=' . (int) $draft['resident_id']));
        }

        $resident = $this->findActiveResident((int) $draft['resident_id']);
        if (!$resident) {
            session()->setFlashdata('error', 'Data warga tidak ditemukan atau sudah tidak aktif.');
            return redirect()->to(base_url('mobile/user/collectoil'));
        }

        return view('mobile/user/camera', ['draft' => $draft, 'resident' => $resident]);
    }

    public function saveCollection()
    {
        $draft = session()->get(self::DRAFT_SESSION_KEY) ?? [];
        $photos = array_values(array_filter(
            $this->request->getFileMultiple('photos') ?? [],
            static fn($photo) => $photo->getError() !== UPLOAD_ERR_NO_FILE
        ));

        if (count($photos) > self::MAX_PHOTOS) {
            return $this->jsonError('Maksimal 4 foto dokumentasi.', [], ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        $photoErrors = $this->validatePhotos($photos);
        if ($photoErrors !== []) {
            return $this->jsonError('Foto dokumentasi belum valid.', $photoErrors, ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (empty($draft['resident_id']) || !isset($draft['qty']) || !is_numeric($draft['qty']) || (float) $draft['qty'] <= 0 || ($draft['unit'] ?? '') !== self::UNIT) {
            return $this->jsonError('Data collect oil belum lengkap.', [], ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        $usersId = (int) session()->get('users_id');
        $assignment = $this->db->table('organization_user ou')
            ->select('ou.organization_program_id')
            ->join('organization_program op', 'op.organization_program_id=ou.organization_program_id', 'inner')
            ->join('usersgroupprogram ugp', 'ugp.users_id=ou.users_id AND ugp.program_id=op.program_id', 'inner')
            ->join('`group` g', 'g.group_id=ugp.group_id', 'inner')
            ->where('ou.users_id', $usersId)->where('ou.active', 1)->where('LOWER(g.name)', 'collector')
            ->get()->getRowArray();
        if (!$assignment) {
            return $this->jsonError('User collector belum memiliki organization aktif.', [], ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }
        $organizationProgramId = (int) $assignment['organization_program_id'];
        $movedFiles = [];
        $this->db->transBegin();
        try {
            $resident = $this->db->table('resident')->where('resident_id', (int) $draft['resident_id'])->where('active', 1)->get()->getRowArray();
            if (!$resident) {
                throw new RuntimeException('Data warga tidak ditemukan atau sudah tidak aktif.');
            }

            $status = $this->db->table('status')->select('status_id')
                ->where('module', 'COLLECTION_VISIT')->where('status_code', 'COMPLETED')->get()->getRowArray();
            if (!$status) {
                throw new RuntimeException('Status COMPLETED untuk COLLECTION_VISIT belum tersedia.');
            }

            $now = date('Y-m-d H:i:s');
            $visitData = [
                'visit_number' => $this->generateUniqueNumber('collection_visit', 'visit_number', 'CV'),
                'users_id' => $usersId,
                'organization_program_id' => $organizationProgramId,
                'resident_id' => (int) $resident['resident_id'],
                'visit_date' => date('Y-m-d', strtotime($now)),
                'visit_time' => date('H:i:s', strtotime($now)),
                'qty' => (float) $draft['qty'],
                'unit' => self::UNIT,
                'status_id' => (int) $status['status_id'],
                'note' => null,
                'created_date' => $now,
                'created_by' => $usersId,
            ];

            if (!$this->collectionVisitModel->insert($visitData)) {
                throw new RuntimeException('Gagal menyimpan transaksi collect oil.');
            }

            $visitId = (int) $this->collectionVisitModel->getInsertID();
            $uploadPath = FCPATH . 'upload/image/collection_visit';
            if ($photos !== [] && !is_dir($uploadPath) && !mkdir($uploadPath, 0775, true) && !is_dir($uploadPath)) {
                throw new RuntimeException('Folder upload foto tidak dapat dibuat.');
            }

            foreach ($photos as $photo) {
                $fileName = $photo->getRandomName();
                $fileType = $photo->getMimeType();
                $fileSize = $photo->getSize();
                $photo->move($uploadPath, $fileName);
                $movedFiles[] = $uploadPath . DIRECTORY_SEPARATOR . $fileName;

                if (!$this->attachmentModel->insert([
                    'collection_visit_id' => $visitId,
                    'file_path' => 'upload/image/collection_visit/' . $fileName,
                    'file_name' => $fileName,
                    'file_type' => $fileType,
                    'file_size' => $fileSize,
                    'created_date' => $now,
                    'created_by' => $usersId,
                ])) {
                    throw new RuntimeException('Gagal menyimpan metadata foto dokumentasi.');
                }
            }

            $balanceQuery = $this->db->query('SELECT * FROM users_collection_balance WHERE users_id = ? FOR UPDATE', [$usersId]);
            if ($balanceQuery === false) {
                throw new RuntimeException('Tabel users_collection_balance belum tersedia. Jalankan migration collect oil terlebih dahulu.');
            }
            $balance = $balanceQuery->getRowArray();
            if ($balance) {
                $balanceSaved = $this->usersBalanceModel->update($usersId, [
                    'total_qty' => (float) $balance['total_qty'] + (float) $visitData['qty'],
                    'total_visit' => (int) $balance['total_visit'] + 1,
                    'last_visit_date' => $visitData['visit_date'],
                    'last_visit_time' => $visitData['visit_time'],
                    'modified_date' => $now,
                ]);
            } else {
                $balanceSaved = $this->usersBalanceModel->insert([
                    'users_id' => $usersId,
                    'total_qty' => $visitData['qty'],
                    'total_visit' => 1,
                    'last_visit_date' => $visitData['visit_date'],
                    'last_visit_time' => $visitData['visit_time'],
                    'modified_date' => $now,
                ]);
            }

            $date = $visitData['visit_date'];
            $year = (int) date('Y', strtotime($date));
            $month = (int) date('m', strtotime($date));
            $this->incrementSummary('users_collection_daily_summary', ['users_id'=>$usersId, 'summary_date'=>$date], $visitData['qty'], 'users_id,summary_date');
            $this->incrementSummary('users_collection_monthly_summary', ['users_id'=>$usersId, 'summary_year'=>$year, 'summary_month'=>$month], $visitData['qty'], 'users_id,summary_year,summary_month');
            $this->incrementSummary('organization_collection_daily_summary', ['organization_program_id'=>$organizationProgramId, 'summary_date'=>$date], $visitData['qty'], 'organization_program_id,summary_date');
            $this->incrementSummary('organization_collection_monthly_summary', ['organization_program_id'=>$organizationProgramId, 'summary_year'=>$year, 'summary_month'=>$month], $visitData['qty'], 'organization_program_id,summary_year,summary_month');

            if (!$balanceSaved || $this->db->transStatus() === false) {
                throw new RuntimeException('Gagal memperbarui ringkasan collection user.');
            }

            $this->db->transCommit();
            session()->remove(self::DRAFT_SESSION_KEY);
            session()->set(self::SUCCESS_SESSION_KEY, $visitId);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Collect minyak berhasil disimpan.',
                'redirect' => base_url('mobile/user/collectsuccess'),
                'csrf_hash' => csrf_hash(),
            ]);
        } catch (Throwable $e) {
            $this->db->transRollback();
            foreach ($movedFiles as $filePath) {
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }

            log_message('error', 'Save collection visit failed: ' . $e->getMessage());
            return $this->jsonError($e->getMessage(), [], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function success()
    {
        $visitId = (int) session()->get(self::SUCCESS_SESSION_KEY);
        $usersId = (int) session()->get('users_id');
        if ($visitId <= 0) {
            session()->setFlashdata('error', 'Data transaksi terakhir tidak ditemukan.');
            return redirect()->to(base_url('mobile/user/home'));
        }

        $collection = $this->db->table('collection_visit cv')
            ->select('cv.collection_visit_id, cv.qty, cv.unit, cv.visit_date, cv.visit_time, u.fullname, ub.total_qty')
            ->join('users u', 'u.users_id = cv.users_id')
            ->join('users_collection_balance ub', 'ub.users_id = cv.users_id')
            ->where('cv.collection_visit_id', $visitId)
            ->where('cv.users_id', $usersId)
            ->get()->getRowArray();
        if (!$collection) {
            session()->remove(self::SUCCESS_SESSION_KEY);
            session()->setFlashdata('error', 'Data transaksi tidak ditemukan.');
            return redirect()->to(base_url('mobile/user/home'));
        }

        return view('mobile/user/collectsuccess', ['collection' => $collection]);
    }

    private function findActiveResident(int $residentId): ?array
    {
        if ($residentId <= 0) {
            return null;
        }

        return $this->residentModel->select('resident_id, resident_code, resident_name')
            ->where('resident_id', $residentId)->where('active', 1)->first();
    }

    private function generateUniqueNumber(string $table, string $column, string $prefix): string
    {
        do {
            $number = $prefix . date('Ymd') . random_int(1000, 9999);
            $exists = $this->db->table($table)->where($column, $number)->countAllResults() > 0;
        } while ($exists);

        return $number;
    }

    private function validatePhotos(array $photos): array
    {
        $errors = [];
        foreach ($photos as $index => $photo) {
            $number = $index + 1;
            if (!$photo->isValid() || $photo->hasMoved()) {
                $errors['photos.' . $index] = 'Foto ' . $number . ' gagal diupload.';
            } elseif (!in_array($photo->getMimeType(), ['image/jpeg', 'image/png'], true)) {
                $errors['photos.' . $index] = 'Foto ' . $number . ' harus berupa JPG, JPEG, atau PNG.';
            } elseif (!in_array(strtolower($photo->getExtension()), ['jpg', 'jpeg', 'png'], true)) {
                $errors['photos.' . $index] = 'Ekstensi foto ' . $number . ' tidak diperbolehkan.';
            } elseif ($photo->getSizeByUnit('kb') > self::MAX_PHOTO_SIZE_KB) {
                $errors['photos.' . $index] = 'Ukuran foto ' . $number . ' maksimal 2 MB.';
            }
        }

        return $errors;
    }

    private function incrementSummary(string $table, array $keys, float $qty, string $uniqueColumns): void
    {
        $columns = array_keys($keys);
        $values = array_values($keys);
        $columns[] = 'total_qty'; $values[] = $qty;
        $columns[] = 'total_visit'; $values[] = 1;
        $columns[] = 'created_date'; $values[] = date('Y-m-d H:i:s');
        $columns[] = 'modified_date'; $values[] = date('Y-m-d H:i:s');
        $quoted = implode(',', array_map(static fn ($column) => '`' . $column . '`', $columns));
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $this->db->query("INSERT INTO `{$table}` ({$quoted}) VALUES ({$placeholders}) ON DUPLICATE KEY UPDATE total_qty=total_qty+VALUES(total_qty), total_visit=total_visit+1, modified_date=VALUES(modified_date)", $values);
    }

    private function jsonError(string $message, array $errors = [], int $statusCode = ResponseInterface::HTTP_BAD_REQUEST)
    {
        return $this->response->setStatusCode($statusCode)->setJSON([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'csrf_hash' => csrf_hash(),
        ]);
    }
}
