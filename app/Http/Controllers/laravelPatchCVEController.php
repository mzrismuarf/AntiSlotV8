<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class laravelPatchCVEController extends Controller
{

    public function index()
    {
        return view('dashboard.defend.laravel.patchcve');
    }

    public function search(Request $request)
    {
        if ($request->has('search')) {
            $folderName = $request->input('folderName');

            if (is_dir($folderName)) {
                $fileList = scandir($folderName);
                $htaccessFiles = array_filter($fileList, function ($fileName) {
                    return preg_match('/\.htaccess$/', $fileName);
                });

                if (count($htaccessFiles) > 0) {
                    return view('dashboard.defend.laravel.patchcve', ['htaccessFiles' => $htaccessFiles, 'folderName' => $folderName]);
                } else {
                    return view('dashboard.defend.laravel.patchcve', ['folderName' => $folderName, 'noHtaccess' => true]);
                }
            } else {
                return view('dashboard.defend.laravel.patchcve', ['error' => 'Directory not found']);
            }
        }
    }

    public function add(Request $request)
    {
        $filePath = $request->input('filePath');
        $existingContent = $request->input('existingContent');
        $contentFromTextarea1 = html_entity_decode($request->input('contentFromTextarea1'));
        $newContent = $existingContent . "\n" . $contentFromTextarea1;
        file_put_contents($filePath, $newContent);
        $fileContent = file_get_contents($filePath);
        return view('dashboard.defend.laravel.patchcve', ['addSuccess' => 'Content added successfully!', 'fileContent' => $fileContent]);
    }

    public function addHtaccess(Request $request)
    {
        $folderName = $request->input('folderName');
        $contentFromTextarea1 = html_entity_decode($request->input('contentFromTextarea1'));
        return view('dashboard.defend.laravel.patchcve', ['confirmation' => true, 'folderName' => $folderName, 'contentFromTextarea1' => $contentFromTextarea1]);
    }

    public function confirmAdd(Request $request)
    {
        $folderName = $request->input('folderName');
        $contentFromTextarea1 = html_entity_decode($request->input('contentFromTextarea1'));
        $htaccessFilePath = $folderName . '/.htaccess';
        file_put_contents($htaccessFilePath, $contentFromTextarea1);
        return view('dashboard.defend.laravel.patchcve', ['addSuccess' => '.htaccess added successfully!']);
    }
}
