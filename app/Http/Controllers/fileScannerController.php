<?php

namespace App\Http\Controllers;

use App\Models\Wordlists;
use App\Models\ResultScan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class fileScannerController extends Controller
{
    //
    public function showForm()
    {
        return view('dashboard.scan.master');
    }

    public function scanFiles(Request $request)
    {

        $totalDirectoryScans = ResultScan::count('directory_scan');
        $totalDirectorySafe = ResultScan::count('directory_safe');
        $totalDirectoryInfected = ResultScan::count('directory_infected');
        $totalBacklinkSlot = ResultScan::count('backlink_slot');

        // ambil nilai dari input form
        $directory = $request->input('directory');

        $wordlistType = $request->input('wordlist_type', 'slot'); // Default to 'slot' if not specified

        // variabel untuk error
        $error = '';
        $safe = '';

        if (!is_dir($directory)) {
            // jika direktori tidak ada
            $error = 'Directory not Found!';
        } else {

            // membaca wordlist dari database dan menyesuaikan opsi nya
            $wordlist = $this->getWordlist($wordlistType);

            // melakukan scanning pada direktori
            $scannedFiles = $this->scanDirectory($directory, $wordlist, $wordlistType);

            // untuk menampilkan hasil dalam tabel
            if (empty($scannedFiles)) {
                // jika hasil scan safe
                $safe = 'No files found containing specified keywords, safe.';
                // hasil inputan masuk ke tabel "result_scans"
                ResultScan::create([
                    'directory_scan' => $directory,
                    'directory_safe' => $directory,
                    'backlink_slot' => null,
                    'directory_infected' => null,
                ]);
            } else {
                foreach ($scannedFiles as $file) {
                    // jika hasil scan menemukan kata kunci dari wordlist
                    // hasil inputan masuk ke tabel "result_scans"
                    ResultScan::create([
                        'directory_scan' => $directory,
                        'directory_infected' => $file['path'],
                        'backlink_slot' => $file['word']
                    ]);
                }
            }
        }


        return view('dashboard.scan.master', [
            'totalDirectoryScans' => $totalDirectoryScans,
            'totalDirectorySafe' => $totalDirectorySafe,
            'totalDirectoryInfected' => $totalDirectoryInfected,
            'totalBacklinkSlot' => $totalBacklinkSlot,
        ])->with([
            'directory' => $directory,
            'error' => $error,
            'safe' => $safe,
            'scannedFiles' => $scannedFiles ?? null, // menggunakan null coalescing operator untuk menghindari error jika $scannedFiles tidak diinisialisasi
            'wordlistType' => $wordlistType,
        ]);
    }

    private function getWordlist($type)
    {
        if ($type === 'best_wordlist_slot') {
            return Wordlists::pluck('best_wordlist_slot')->filter()->toArray();
        } else {
            return Wordlists::pluck('slot')->filter()->toArray();
        }
    }


    private function scanDirectory($directory, $wordlist, $wordlistType)
    {
        $files = scandir($directory);
        $results = [];

        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $path = $directory . '/' . $file;
                if (is_dir($path)) {
                    // Jika $path adalah direktori, lakukan rekursi
                    $subResults = $this->scanDirectory($path, $wordlist, $wordlistType);
                    $results = array_merge($results, $subResults);
                } else {
                    // jika $path adalah file, baca isinya dan cek keterdapatannya dalam wordlist
                    $content = file_get_contents($path);
                    foreach ($wordlist as $complexWord) {
                        // opsi untuk wordlist kompleks (best wordlist slot)
                        if ($wordlistType === 'best_wordlist_slot') {
                            if ($this->matchComplexPattern($content, $complexWord)) {
                                $results[] = [
                                    'path' => $path,
                                    'word' => $complexWord,
                                    'modification_time' => date('F d Y H:i:s', filemtime($path))
                                ];
                                break;
                            } else {
                                // stripos digunakan untuk pencarian case-insensitive
                                if (stripos($content, trim($complexWord)) !== false) {
                                    // jika kata ditemukan dalam file, tambahkan informasi file ke dalam hasil
                                    $results[] = [
                                        'path' => $path,
                                        'word' => $complexWord,
                                        'modification_time' => date('F d Y H:i:s', filemtime($path))
                                    ];
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $results;
    }

    // fungsi untuk wordlist kompleks
    private function matchComplexPattern($content, $pattern)
    {
        $subPatterns = explode(' + ', $pattern);
        foreach ($subPatterns as $subPattern) {
            if (!$this->matchSinglePattern($content, trim($subPattern))) {
                return false;
            }
        }
        return true;
    }

    private function matchSinglePattern($content, $pattern)
    {
        $pattern = str_replace('*', '.*', preg_quote($pattern, '/'));
        return preg_match("/.*$pattern.*/i", $content) === 1;
    }


    // fungsi untuk mendapatkan isi dari file yang mau diedit
    public function getFileContent(Request $request)
    {
        try {
            $filePath = $request->input('filePath');
            $fileContent = file_get_contents($filePath);
            return response()->json(['content' => $fileContent]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function saveFileContent(Request $request)
    {
        try {
            $filePath = $request->input('filePath');
            $newContent = $request->input('newContent');

            File::put($filePath, $newContent);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // fungsi untuk menghapus file
    public function deleteFile(Request $request)
    {
        $filePath = $request->input('filePath');

        if (file_exists($filePath)) {
            unlink($filePath); // This will delete the file
            return response()->json(['message' => 'File deleted successfully']);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
}
