<?php

use App\Http\Controllers\ChartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\scanController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\defendController;
use App\Http\Controllers\laravelController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\wordpressController;
use App\Http\Controllers\fileScannerController;
use App\Http\Controllers\laravelPatchCVEController;
use App\Http\Controllers\wordpressXmlrpcController;
use App\Http\Controllers\DisableFileModifController;
use App\Http\Controllers\laravelValidationFileController;
use App\Http\Controllers\settingsController;
use App\Http\Controllers\userController;
use App\Http\Controllers\wordlistController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// ======= DASHBOARD ======= \\
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/profile', [userController::class, 'profile'])->name('profile');
    Route::put('/dashboard/profile/{user}', [userController::class, 'update'])->name('profile.update');
    Route::get('/dashboard/settings', [settingsController::class, 'index'])->name('dashboard.settings');
    Route::post('/dashboard/settings', [settingsController::class, 'changePassword'])->name('dashboard.settings.changepass');
    Route::delete('/dashboard/{id}', [dashboardController::class, 'destroy'])->name('dashboard.destroy');
});


// update rute "/" ke "/dashboard" jika user sudah login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
});


Route::middleware(['web'])->group(function () {
    // Rute login
    Route::get('/login', [loginController::class, 'index'])->name('login')->middleware('guest');
    Route::post('/log', [loginController::class, 'login'])->name('login.store');

    // Rute logout
    Route::post('/logout', [loginController::class, 'logout'])->name('logout');

    // // Rute register
    // Route::get('/register', [registerController::class, 'index'])->name('register');
    // Route::post('/regist', [registerController::class, 'store'])->name('register.store');
});


// ======= MENU FILE SCANNER ======= \\
Route::middleware('auth')->group(function () {
    Route::get('/scan', [scanController::class, 'index'])->name('scan');
    Route::get('/file-scanner', [fileScannerController::class, 'showForm']);
    Route::post('/file-scanner/scan', [fileScannerController::class, 'scanFiles']);


    // route for get file, edit, save, delete in menu scan
    Route::get('get-file-content', [fileScannerController::class, 'getFileContent'])->name('getFileContent');
    Route::post('save-file-content', [fileScannerController::class, 'saveFileContent'])->name('saveFileContent');
    Route::post('/delete-file', [FileScannerController::class, 'deleteFile'])->name('deleteFile');
});

// ======= MENU DEFEND ======= \\
Route::middleware('auth')->group(function () {
    Route::get('/defend', [defendController::class, 'index'])->name('defend');

    // SUB MENU DEFEND - WORDPRESS
    Route::get('/defend/wordpress', [wordpressController::class, 'index'])->name('wordpress');

    // disable xmlrpc
    Route::get('/defend/wp/xmlrpc', [wordpressXmlrpcController::class, 'index'])->name('xmlrpc');
    Route::post('/defend/wp/xmlrpc/search', [wordpressXmlrpcController::class, 'search'])->name('search');
    Route::post('/defend/wp/xmlrpc/add', [wordpressXmlrpcController::class, 'add'])->name('add');

    // disable file modif
    Route::get('/defend/wp/disablefile', [DisableFileModifController::class, 'index'])->name('defend.wp.disablefile');
    Route::post('/defend/wp/disablefile/search', [DisableFileModifController::class, 'search'])->name('defend.wp.disablefile.search');
    Route::post('/defend/wp/disablefile/add', [DisableFileModifController::class, 'add'])->name('defend.wp.disablefile.add');

    // SUB MENU DEFEND - LARAVEL
    Route::get('/defend/laravel', [laravelController::class, 'index'])->name('laravel');

    // patch cve laravel
    Route::get('/defend/larav/patchcve', [laravelPatchCVEController::class, 'index'])->name('laravel.patchcve');
    Route::post('/defend/larav/patchcve/search', [laravelPatchCVEController::class, 'search'])->name('laravel.patchcve.search');
    Route::post('/defend/larav/patchcve/add', [laravelPatchCVEController::class, 'add'])->name('laravel.patchcve.add');
    Route::post('/defend/larav/patchcve/addHtaccess', [laravelPatchCVEController::class, 'addHtaccess'])->name('laravel.patchcve.addHtaccess');
    Route::post('/defend/larav/patchcve/confirmAdd', [laravelPatchCVEController::class, 'confirmAdd'])->name('laravel.patchcve.confirmAdd');

    // validation file upload
    Route::get('/defend/larav/validationfile', [laravelValidationFileController::class, 'index'])->name('laravel.validationfile');
    Route::post('/defend/larav/validationfile', [laravelValidationFileController::class, 'search']);
    Route::post('/defend/larav/validationfile/add', [laravelValidationFileController::class, 'add']);
    Route::post('/defend/larav/validationfile/addHtaccess', [laravelValidationFileController::class, 'addHtaccess']);
    Route::post('/defend/larav/validationfile/confirmAdd', [laravelValidationFileController::class, 'confirmAdd']);
});

// ======= MENU WORDLIST ======= \\
Route::middleware('auth')->group(function () {
    Route::get('/wordlist', [wordlistController::class, 'index'])->name('wordlist');
    Route::put('/wordlist/{id}', [WordlistController::class, 'update'])->name('wordlist.update');    
    Route::get('/wordlist/{id}/edit', [WordlistController::class, 'edit'])->name('wordlist.edit');
    Route::delete('/wordlist/{id}', [WordlistController::class, 'destroy'])->name('wordlist.destroy');
});
