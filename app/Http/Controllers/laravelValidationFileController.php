<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class laravelValidationFileController extends Controller
{
    //

    public function index()
    {
        return view('dashboard.defend.laravel.validationfileupload');
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
                return view('dashboard.defend.laravel.validationfileupload', ['htaccessFiles' => $htaccessFiles, 'folderName' => $folderName]);
            } else {
                return view('dashboard.defend.laravel.validationfileupload', ['folderNotFound' => true]);
            }
        }
    }

    public function add(Request $request)
    {
        if ($request->has('add')) {
            $filePath = $request->input('filePath');
            $existingContent = $request->input('existingContent');
            $contentFromTextarea1 = html_entity_decode($request->input('contentFromTextarea1'));
            $newContent = $existingContent . "\n" . $contentFromTextarea1;
            file_put_contents($filePath, $newContent);
            return view('dashboard.defend.laravel.validationfileupload', ['addSuccess' => true, 'filePath' => $filePath]);
        }
    }

    public function addHtaccess(Request $request)
    {
        if ($request->has('addHtaccess')) {
            $folderName = $request->input('folderName');
            $contentFromTextarea1 = html_entity_decode($request->input('contentFromTextarea1'));
            return view('dashboard.defend.laravel.validationfileupload', ['confirmation' => true, 'folderName' => $folderName, 'contentFromTextarea1' => $contentFromTextarea1]);
        }
    }

    public function confirmAdd(Request $request)
    {
        if ($request->has('confirmAdd')) {
            $folderName = $request->input('folderName');
            $contentFromTextarea1 = html_entity_decode($request->input('contentFromTextarea1'));
            $htaccessFilePath = $folderName . '/.htaccess';
            file_put_contents($htaccessFilePath, $contentFromTextarea1);
            return view('dashboard.defend.laravel.validationfileupload', ['addSuccess' => true, 'filePath' => $htaccessFilePath]);
        }
    }
}
