<?php

namespace App\Http\Controllers;

use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Wordlists;
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


        $wordlistSlot = Wordlists::paginate(10);



        return view('dashboard.wordlist.master', [
            'totalDirectoryScans' => $totalDirectoryScans,
            'totalDirectorySafe' => $totalDirectorySafe,
            'totalDirectoryInfected' => $totalDirectoryInfected,
            'totalBacklinkSlot' => $totalBacklinkSlot,
        ], compact('wordlistSlot'));
    }

    public function edit($id)
    {
        $wordlist = Wordlists::findOrFail($id);
        return view('dashboard.wordlist.edit', compact('wordlist'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'slot' => 'nullable|string|max:255',
            'backdoor' => 'nullable|string|max:255',
            'disable_file_modif' => 'nullable|string|max:255',
            'disable_xmlrpc' => 'nullable|string|max:255',
            'patch_cve' => 'nullable|string|max:255',
            'validation_upload' => 'nullable|string|max:255',
        ]);

        $wordlist = Wordlists::findOrFail($id);
        $wordlist->update($request->only([
            'slot',
            'backdoor',
            'disable_file_modif',
            'disable_xmlrpc',
            'patch_cve',
            'validation_upload'
        ]));

        return redirect()->route('wordlist')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        Wordlists::findOrFail($id)->delete();

        return redirect()->route('wordlist')->with('success', 'Data berhasil dihapus');
    }

    // upload wordlist
    public function create()
    {
        return view('dashboard.wordlist.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'slot' => 'nullable|string|max:255',
            'backdoor' => 'nullable|string|max:255',
            'disable_file_modif' => 'nullable|string|max:255',
            'disable_xmlrpc' => 'nullable|string|max:255',
            'patch_cve' => 'nullable|string|max:255',
            'validation_upload' => 'nullable|string|max:255',
        ]);

        Wordlists::create($request->all());

        return redirect()->route('wordlists')->with('success', 'Wordlist berhasil ditambahkan');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);
    
        $file = $request->file('file');
    
        $spreadsheet = IOFactory::load($file->getPathName());
    
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
    
        foreach ($rows as $row) {
            Wordlists::create([
                'slot' => $row[0] ?? null,
                'backdoor' => $row[1] ?? null,
            ]);
        }
    
        return redirect()->route('wordlist')->with('success', 'Wordlist berhasil diupload dari file Excel');
    }
}
