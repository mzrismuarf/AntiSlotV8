<?php

namespace App\Http\Controllers;

use App\Models\ResultScan;
use Illuminate\Http\Request;

class defendController extends Controller
{
    //

    public function index()
    {
        $totalDirectoryScans = ResultScan::count('directory_scan');
        $totalDirectorySafe = ResultScan::count('directory_safe');
        $totalDirectoryInfected = ResultScan::count('directory_infected');
        $totalBacklinkSlot = ResultScan::count('backlink_slot');

        return view('dashboard.defend.defend', [
            'totalDirectoryScans' => $totalDirectoryScans,
            'totalDirectorySafe' => $totalDirectorySafe,
            'totalDirectoryInfected' => $totalDirectoryInfected,
            'totalBacklinkSlot' => $totalBacklinkSlot,
        ]);
    }
}
