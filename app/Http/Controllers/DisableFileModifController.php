<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DisableFileModifController extends Controller
{

    public function index()
    {
        return view('dashboard.defend.wordpress.disablefilemodif');
    }

    public function search(Request $request)
    {
        $folderName = $request->input('folderName');

        $validator = Validator::make($request->all(), [
            'folderName' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['Please provide a folder name'])->withInput();
        }

        if (is_dir($folderName)) {
            $fileList = scandir($folderName);
            $wpconfigFiles = array_filter($fileList, function ($fileName) {
                return preg_match('/\wp-config.php$/', $fileName);
            });

            return view('dashboard.defend.wordpress.disablefilemodif', compact('wpconfigFiles', 'folderName'));
        } else {
            return view('dashboard.defend.wordpress.disablefilemodif')->with('directoryNotFound', true);
        }
    }


    public function add(Request $request)
    {
        $filePath = $request->input('filePath');
        $existingContent = $request->input('existingContent');
        $contentFromTextarea1 = html_entity_decode($request->input('contentFromTextarea1'));
        $newContent = $existingContent . "\n" . $contentFromTextarea1;
        file_put_contents($filePath, $newContent);

        $newContentAdded = file_get_contents($filePath);

        return view('dashboard.defend.wordpress.disablefilemodif', compact('newContentAdded'));
    }
}
