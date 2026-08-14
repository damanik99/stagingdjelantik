<?php

namespace App\Models;

use CodeIgniter\Model;

class ShipmentModel extends Model
{
    protected $table            = 'shipment';
    protected $primaryKey       = 'shipment_id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'shipment_number',
        'purchase_order_id',
        'shipment_type',
        'driver_id',
        'vehicle_id',
        'departure_at',
        'arrival_at',
        'status_id',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by'
    ];

    public function generateShipmentNumber()
    {
        $monthRoman = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        $month = date('n');
        $year  = date('y');

        $suffix = '/SJ/' . $monthRoman[$month] . '/' . $year;

        $last = $this->select('shipment_number')
                ->orderBy('shipment_id', 'DESC')
                ->first();
 
        if ($last) {

            $parts = explode('/', $last['shipment_number']);
            $number = (int) $parts[0] + 1;

        } else {

            $number = 1;

        }

        return sprintf('%03d', $number) . $suffix;
    }

    public function getActiveShipmentDriver($driverId)
    {
        return $this->db->table('shipment a')
            ->select("
                a.shipment_id,
                a.shipment_number,
                a.departure_at,

                s.company_name AS supplier,
                b.company_name AS buyer,

                st.status_name AS status,
                st.status_code,

                sp.name AS supplier_program,
                sct.type_name AS supplier_company_type,

                bp.name AS buyer_program,
                bct.type_name AS buyer_company_type
            ")

            ->join('status st', 'a.status_id = st.status_id')

            // Supplier Company Program
            ->join('company_program scp', 'a.supplier_company_program_id = scp.company_program_id', 'left')
            ->join('company s', 'scp.company_id = s.company_id', 'left')
            ->join('program sp', 'scp.program_id = sp.program_id', 'left')
            ->join('companytype sct', 'scp.company_type_id = sct.type_id', 'left')

            // Buyer Company Program
            ->join('company_program bcp', 'a.buyer_company_program_id = bcp.company_program_id', 'left')
            ->join('company b', 'bcp.company_id = b.company_id', 'left')
            ->join('program bp', 'bcp.program_id = bp.program_id', 'left')
            ->join('companytype bct', 'bcp.company_type_id = bct.type_id', 'left')

            ->where('a.driver_id', $driverId)
            ->where('LOWER(st.status_code) !=', 'scmpl')

            ->groupStart()
                ->where('a.departure_at IS NULL')
                ->orWhere('DATE(a.departure_at) <=', date('Y-m-d'))
            ->groupEnd()

            ->orderBy('a.shipment_id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getDetailShipmentDriver($shipmentId, $driverId)
    {
        return $this->db->table('shipment a')
            ->select("
                a.*,
                b.company_name AS supplier,
                c.company_name AS buyer,
                d.status_name AS status,

                sp.name AS supplier_program,
                sct.type_name AS supplier_company_type,

                bp.name AS buyer_program,
                bct.type_name AS buyer_company_type
            ")

            ->join('company_program scp', 'a.supplier_company_program_id = scp.company_program_id', 'left')
            ->join('company b', 'scp.company_id = b.company_id', 'left')
            ->join('program sp', 'scp.program_id = sp.program_id', 'left')
            ->join('companytype sct', 'scp.company_type_id = sct.type_id', 'left')

            ->join('company_program bcp', 'a.buyer_company_program_id = bcp.company_program_id', 'left')
            ->join('company c', 'bcp.company_id = c.company_id', 'left')
            ->join('program bp', 'bcp.program_id = bp.program_id', 'left')
            ->join('companytype bct', 'bcp.company_type_id = bct.type_id', 'left')

            ->where('a.shipment_id', $shipmentId)
            ->where('a.driver_id', $driverId)

            ->get()
            ->getRowArray();
    }

    public function getDetailShipment($shipmentId)
    {
        return $this->db->table('shipment a')
            ->select("
                a.*,
                b.company_name AS supplier,
                c.company_name AS buyer,
                d.status_name AS status,
                sp.name AS supplier_program,
                sct.type_name AS supplier_company_type,
                bp.name AS buyer_program,
                bct.type_name AS buyer_company_type,
                dv.driver_name,
                vh.plate_number,
                d.status_code
            ")

            ->join('status d', 'a.status_id = d.status_id')

            ->join('company_program scp', 'a.supplier_company_program_id = scp.company_program_id', 'left')
            ->join('company b', 'scp.company_id = b.company_id', 'left')
            ->join('program sp', 'scp.program_id = sp.program_id', 'left')
            ->join('companytype sct', 'scp.company_type_id = sct.type_id', 'left')

            ->join('company_program bcp', 'a.buyer_company_program_id = bcp.company_program_id', 'left')
            ->join('company c', 'bcp.company_id = c.company_id', 'left')
            ->join('program bp', 'bcp.program_id = bp.program_id', 'left')
            ->join('companytype bct', 'bcp.company_type_id = bct.type_id', 'left')

            ->join('driver dv', 'a.driver_id = dv.driver_id')
            ->join('vehicle vh', 'a.vehicle_id = vh.vehicle_id')

            ->where('a.shipment_id', $shipmentId)
            ->get()
            ->getRowArray();
    }

    public function getShipmentTracking($shipmentTrackId)
    {
        return $this->db->table('shipment_tracking a')
            ->select("
                a.*,
                c.company_name AS supplier,
                d.company_name AS buyer,
                e.status_name AS status,
                b.shipment_number,
                b.shipment_id,

                sp.name AS supplier_program,
                sct.type_name AS supplier_company_type,

                bp.name AS buyer_program,
                bct.type_name AS buyer_company_type
            ")

            // Supplier
            ->join('company_program scp', 'b.supplier_company_program_id = scp.company_program_id', 'left')
            ->join('company c', 'scp.company_id = c.company_id', 'left')
            ->join('program sp', 'scp.program_id = sp.program_id', 'left')
            ->join('companytype sct', 'scp.company_type_id = sct.company_type_id', 'left')

            // Buyer
            ->join('company_program bcp', 'b.buyer_company_program_id = bcp.company_program_id', 'left')
            ->join('company d', 'bcp.company_id = d.company_id', 'left')
            ->join('program bp', 'bcp.program_id = bp.program_id', 'left')
            ->join('companytype bct', 'bcp.company_type_id = bct.company_type_id', 'left')

            ->where('a.tracking_id', $shipmentTrackId)
            ->get()
            ->getRowArray();
    }

    public function getShipmentId($shipmentId)
    {
        return $this->db->table('shipment_tracking a')
            ->select("
                a.*,

                s.company_name AS supplier,
                b.company_name AS buyer,

                st.status_name AS status,

                sh.shipment_number,
                sh.shipment_id,

                sp.name AS supplier_program,
                sct.type_name AS supplier_company_type,

                bp.name AS buyer_program,
                bct.type_name AS buyer_company_type
            ")

            ->join('shipment sh', 'a.shipment_id = sh.shipment_id')
            ->join('status st', 'a.status_id = st.status_id')

            // Supplier Company Program
            ->join('company_program scp', 'sh.supplier_company_program_id = scp.company_program_id', 'left')
            ->join('company s', 'scp.company_id = s.company_id', 'left')
            ->join('program sp', 'scp.program_id = sp.program_id', 'left')
            ->join('companytype sct', 'scp.company_type_id = sct.type_id', 'left')

            // Buyer Company Program
            ->join('company_program bcp', 'sh.buyer_company_program_id = bcp.company_program_id', 'left')
            ->join('company b', 'bcp.company_id = b.company_id', 'left')
            ->join('program bp', 'bcp.program_id = bp.program_id', 'left')
            ->join('companytype bct', 'bcp.company_type_id = bct.type_id', 'left')

            ->where('a.shipment_id', $shipmentId)
            ->get()
            ->getRowArray();
    }

    public function dataShipment($shipmentId)
    {
        $sql = "
            SELECT a.*, d.driver_name, v.plate_number, s.status_id, s.status_code FROM shipment a
            JOIN driver d ON a.driver_id = d.driver_id
            JOIN vehicle v ON a.vehicle_id = v.vehicle_id
            JOIN status s ON a.status_id = s.status_id
            WHERE a.shipment_id = ?
        ";

        return $this->db->query($sql, [$shipmentId])->getRowArray();
    }

    public function driverShipmentDetail($shipmentId)
    {
        return $this->db->table('shipment_detail a')
            ->select('
                a.*,
                b.shipment_number,
                d.warehouse_name,
                o.organization_name,
                e.status_code,
                e.status_name,
                o.address AS address
            ')
            ->join('shipment b', 'a.shipment_id = b.shipment_id')
            ->join(
                'organization_program c',
                'a.organization_program_id = c.organization_program_id',
                'left'
            )
            ->join(
                'organization o',
                'c.organization_id = o.organization_id',
                'left'
            )
            ->join(
                'warehouse d',
                'a.warehouse_id = d.warehouse_id',
                'left'
            )
            ->join(
                'status e',
                'a.status_id = e.status_id'
            )
            ->where('a.shipment_id', $shipmentId)
            ->orderBy('a.sequence_no', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function driverSipment($driverId)
    {
        $sql = "
            SELECT a.*, d.driver_name, v.plate_number, s.status_id, s.status_code 
            FROM shipment a
            JOIN driver d ON a.driver_id = d.driver_id
            JOIN vehicle v ON a.vehicle_id = v.vehicle_id
            JOIN status s ON a.status_id = s.status_id
            WHERE a.driver_id = ?
        ";

        return $this->db->query($sql, [$driverId])->getResultArray();
    }

    public function driverShipmentById($shipmentId)
    {
        return $this->db->table('shipment a')
            ->select('
                a.*,
                d.driver_name,
                v.plate_number,
                s.status_code
            ')
            ->join('driver d', 'a.driver_id = d.driver_id', 'left')
            ->join('vehicle v', 'a.vehicle_id = v.vehicle_id', 'left')
            ->join('status s', 'a.status_id = s.status_id', 'left')
            ->where('a.shipment_id', $shipmentId)
            ->get()
            ->getRowArray();
    }

    public function driverDestination($shipmentDetailId)
    {
        return $this->db->table('shipment_detail a')
            ->select('
                a.*,

                b.shipment_number,
                b.driver_id,

                d.warehouse_name,
                d.address AS warehouse_address,
                d.latitude AS warehouse_latitude,
                d.longitude AS warehouse_longitude,

                o.organization_name,
                o.address AS organization_address,
                o.latitude AS organization_latitude,
                o.longitude AS organization_longitude,

                e.status_id,
                e.status_code
            ')
            ->join(
                'shipment b',
                'a.shipment_id = b.shipment_id',
                'left'
            )
            ->join(
                'organization_program c',
                'a.organization_program_id = c.organization_program_id',
                'left'
            )
            ->join(
                'organization o',
                'c.organization_id = o.organization_id',
                'left'
            )
            ->join(
                'warehouse d',
                'a.warehouse_id = d.warehouse_id',
                'left'
            )
            ->join(
                'status e',
                'a.status_id = e.status_id',
                'left'
            )
            ->where(
                'a.shipment_detail_id',
                $shipmentDetailId
            )
            ->get()
            ->getRowArray();
    }

    public function getStatusByCode($statusCode)
    {
        return $this->db->table('status')
            ->where('status_code', $statusCode)
            ->get()
            ->getRowArray();
    }

    public function updateShipmentDetailStatusByCode($shipmentDetailId, $statusCode)
    {
        $status = $this->db->table('status')
            ->where('status_code', $statusCode)
            ->get()
            ->getRowArray();

        if (!$status) {
            return false;
        }

        return $this->db->table('shipment_detail')
            ->where('shipment_detail_id', $shipmentDetailId)
            ->update([
                'status_id' => $status['status_id'],
                'modified_date' => date('Y-m-d H:i:s'),
            ]);
    }



}