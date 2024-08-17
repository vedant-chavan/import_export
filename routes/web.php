<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportExportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('import',[ImportExportController::class,'show'])->name('import');
Route::get('get_data',[ImportExportController::class,'getData'])->name('get_data');
Route::post('upload_file',[ImportExportController::class,'uploadFile'])->name('upload_file');
Route::get('get_each_row_data/{unique_id}',[ImportExportController::class,'getEachRowData'])->name('get_each_row_data');
Route::get('download_zip', [ImportExportController::class, 'downloadZip'])->name('download');