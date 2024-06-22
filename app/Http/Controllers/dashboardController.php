<?php

namespace App\Http\Controllers;

use App\Charts\ResultScanChart;
use Carbon\Carbon;
use App\Models\ResultScan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    public function index(ResultScanChart $resultScanChart)
    {
        // ambil jumlah record dari tabel result_scans pada kolom directory_scan
        $totalDirectoryScans = ResultScan::count('directory_scan');
        $totalDirectorySafe = ResultScan::count('directory_safe');
        $totalDirectoryInfected = ResultScan::count('directory_infected');
        $totalBacklinkSlot = ResultScan::count('backlink_slot');

        // $ResultData = ResultScan::all();
        $ResultData = ResultScan::paginate(10);
        // result for chart
        $chartData = $resultScanChart->build();

        return view('dashboard.dashboard', [
            'totalDirectoryScans' => $totalDirectoryScans,
            'totalDirectorySafe' => $totalDirectorySafe,
            'totalDirectoryInfected' => $totalDirectoryInfected,
            'totalBacklinkSlot' => $totalBacklinkSlot,
            'chartData' => $chartData
        ], compact('ResultData'));
    }

    public function destroy($id)
    {
        $ResultData = ResultScan::findOrFail($id);
        $ResultData->delete();
        if ($ResultData) {
            return redirect()->route('dashboard')->with('success', 'Delete Success');
        } else {
            return redirect()->route('dashboard')->with('failed', 'Delete Failed');
        }

        // return redirect()->route('dashboard')->with('success', 'Data berhasil dihapus.');
    }
}
