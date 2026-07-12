<?php
if (!function_exists('generateCustomMonthlyRanges')) {
    /**
     * Generate custom period ranges per bulan dengan tanggal start & end tetap (kecuali tidak ada, maka ambil tanggal terakhir di bulan).
     * @param string $start_date Format 'Y-m-d'
     * @param string $end_date Format 'Y-m-d'
     * @param int $jumlah_periode Jumlah periode yang ingin ditampilkan
     * @return array
     */
    function generateCustomMonthlyRanges($start_date, $end_date, $jumlah_periode = 6) {
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);

        $start_day = (int)$start->format('d');
        $end_day   = (int)$end->format('d');

        $ranges = [];

        for ($i = 0; $i < $jumlah_periode; $i++) {
            // Hitung tanggal start & end untuk periode ke-i
            $month_start = (clone $start)->modify("+$i month");
            $month_end   = (clone $end)->modify("+$i month");

            // Handle tanggal end tidak ada (misal 31 Februari)
            $end_month_days = (int)$month_end->format('t');
            if ($end_day > $end_month_days) {
                $month_end->setDate($month_end->format('Y'), $month_end->format('m'), $end_month_days);
            }

            // Handle tanggal start tidak ada (misal 31 Februari)
            $start_month_days = (int)$month_start->format('t');
            if ($start_day > $start_month_days) {
                $month_start->setDate($month_start->format('Y'), $month_start->format('m'), $start_month_days);
            }

            $ranges[] = [
                'start' => $month_start->format('Y-m-d'),
                'end'   => $month_end->format('Y-m-d')
            ];
        }

        return $ranges;
    }
}