<?php

namespace App\Charts;

use App\Models\ResultScan;

class ResultScanChart
{
    public function build()
    {
        $monthlySafeCounts = [];
        $monthlyInfectedCounts = [];

        for ($i = 1; $i <= 12; $i++) {
            $resultScans = ResultScan::whereYear('created_at', '=', date('Y'))
                ->whereMonth('created_at', '=', $i)
                ->get();

            $monthlySafeCount = $resultScans->where('directory_safe', true)->count();
            $monthlyInfectedCount = $resultScans->where('directory_infected', true)->count();

            $monthlySafeCounts[] = $monthlySafeCount;
            $monthlyInfectedCounts[] = $monthlyInfectedCount;
        }

        $labels = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return [
            'labels' => $labels,
            'safeCounts' => $monthlySafeCounts,
            'infectedCounts' => $monthlyInfectedCounts
        ];
    }
}
