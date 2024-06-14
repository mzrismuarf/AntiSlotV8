<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class wordpressXmlrpcController extends Controller
{
    //

    public function index()
    {
        return view('dashboard.defend.wordpress.xmlrpc');
    }

    public function search(Request $request)
    {
        $folderName = $request->input('folderName');
        $fileList = scandir($folderName);
        $htaccessFiles = array_filter($fileList, function ($fileName) {
            return preg_match('/\.htaccess$/', $fileName);
        });

        return view('dashboard.defend.wordpress.xmlrpc', ['htaccessFiles' => $htaccessFiles, 'folderName' => $folderName]);
    }

    public function add(Request $request)
    {
        $filePath = $request->input('filePath');
        $existingContent = $request->input('existingContent');
        $contentFromTextarea1 = html_entity_decode($request->input('contentFromTextarea1'));
        $newContent = $existingContent . "\n" . $contentFromTextarea1;
        file_put_contents($filePath, $newContent);
        $addedContent = file_get_contents($filePath);

        return view('dashboard.defend.wordpress.xmlrpc', ['addedContent' => $addedContent]);
    }
}
