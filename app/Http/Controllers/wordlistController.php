<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ResultScan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class wordlistController extends Controller
{
    public function index()
    {
        $totalDirectoryScans = ResultScan::count('directory_scan');
        $totalDirectorySafe = ResultScan::count('directory_safe');
        $totalDirectoryInfected = ResultScan::count('directory_infected');
        $totalBacklinkSlot = ResultScan::count('backlink_slot');

        $wordlist = file_get_contents(Storage::path('public/wordlist.txt'));


        return view('dashboard.wordlist.master', [
            'totalDirectoryScans' => $totalDirectoryScans,
            'totalDirectorySafe' => $totalDirectorySafe,
            'totalDirectoryInfected' => $totalDirectoryInfected,
            'totalBacklinkSlot' => $totalBacklinkSlot,
        ], compact('wordlist'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'contentFromTextarea1' => 'required',
        ], [
            'contentFromTextarea1.required' => 'Wordlist cannot be empty.',
        ]);

        try {
            $content = $request->input('contentFromTextarea1');
            $currentContent = file_get_contents(Storage::path('public/wordlist.txt'));

            if ($content === $currentContent) {
                return redirect()->route('wordlist')->with('info', 'No changes detected in the wordlist.');
            }

            file_put_contents(Storage::path('public/wordlist.txt'), $content);
            return redirect()->route('wordlist')->with('success', 'Wordlist updated successfully!');
        } catch (Exception $e) {
            return redirect()->route('wordlist')->with('error', 'Failed to update wordlist. Please try again.');
        }
    }
}
