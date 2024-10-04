<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Wordlists;
use App\Models\ResultScan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
            'best_wordlist_slot' => 'nullable|string|max:255',
        ]);

        $wordlist = Wordlists::findOrFail($id);
        $wordlist->update($request->only([
            'slot',
            'backdoor',
            'disable_file_modif',
            'disable_xmlrpc',
            'patch_cve',
            'validation_upload',
            'best_wordlist_slot'
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
            'best_wordlist_slot' => 'nullable|string|max:255',
        ]);

        Wordlists::create($request->all());

        return redirect()->route('wordlist')->with('success', 'Wordlist berhasil ditambahkan');
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
    
        foreach ($rows as $index => $row) {
            // skip header template excel
            if ($index === 0) {
                continue;
            }
        
            Wordlists::create([
                'slot' => $row[0] ?? null,
                'backdoor' => $row[1] ?? null,
                'disable_file_modif' => $row[2] ?? null,
                'disable_xmlrpc' => $row[3] ?? null,
                'patch_cve' => $row[4] ?? null,
                'validation_upload' => $row[5] ?? null,
                'best_wordlist_slot' => $row[6] ?? null,
            ]);
        }
    
        return redirect()->route('wordlist')->with('success', 'Wordlist berhasil diupload dari file Excel');
    }
    
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // set header
        $headers = ['Slot', 'Backdoor', 'Disabel File Modif', 'Disable XMLRPC', 'Patch CVE', 'Validation File Upload', 'Best Wordlist Slot'];
        $sheet->fromArray($headers, null, 'A1');
    
        // apply table style for the header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '0d84eb'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];
    
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);
    
        foreach (range(1, 1) as $row) {
            $sheet->getRowDimension($row)->setRowHeight(20); // set height of the first row
        }
    
        // set border for the header
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '43a4eb'],
                ],
            ],
        ];
    
        $sheet->getStyle('A1:G1')->applyFromArray($borderStyle);
    
        // adjust column widths
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setWidth(45);
        }
    
        $writer = new Xlsx($spreadsheet);
        $fileName = 'wordlist_template.xlsx';
    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
        exit;
    }
      
}
