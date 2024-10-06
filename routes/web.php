<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\HongkongController;
use App\Http\Controllers\MalaysiaController;
use App\Http\Controllers\SingaporeController;
use App\Http\Controllers\TaiwanController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Filament\Pages\Workers;



//---------------------------------------------------------------- Blog
// Route::get('/', function () {
//     return Redirect::guest('blogs');
// })->name('home');

//---------------------------------------------------------------- Admin
Route::get('/', function () {
    return Redirect::guest('admin');
})->name('home');

Route::get('/login', function () {
    return redirect('/admin/login'); // Sesuaikan rute ini jika halaman login Anda berbeda
})->name('login');

Route::post('/logout', function () {
    auth('web')->logout();
    return redirect('/');
})->name('logout');

//---------------------------------------------------------------- Foto Biodata
Route::get('/biodata/foto/{filename}', 'HongkongController@showPhoto')->name('biodata.photo');
Route::get('/biodata/foto/{filename}', 'TaiwanController@showPhoto')->name('biodata.photo');
Route::get('/biodata/foto/{filename}', 'SingaporeController@showPhoto')->name('biodata.photo');
Route::get('/biodata/foto/{filename}', 'MalaysiaController@showPhoto')->name('biodata.photo');
//---------------------------------------------------------------- Biodata
Route::get('/hongkong/{id}/pdf/download', [HongkongController::class, 'download'])
    ->name('hongkong.pdf.download')
    ->middleware('auth');  // Enforce authentication if needed
Route::get('/taiwan/{id}/pdf/download', [TaiwanController::class, 'download'])
    ->name('taiwan.pdf.download')
    ->middleware('auth');  // Enforce authentication if needed
Route::get('/singapore/{id}/pdf/download', [SingaporeController::class, 'download'])
    ->name('singapore.pdf.download')
    ->middleware('auth');  // Enforce authentication if needed
Route::get('/malaysia/{id}/pdf/download', [MalaysiaController::class, 'download'])
    ->name('malaysia.pdf.download')
    ->middleware('auth');

    use App\Http\Controllers\LaporanController;

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/pdf/download', [LaporanController::class, 'generatePdf'])->name('laporan.pdf.download');
