<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RtController;
use App\Http\Controllers\RwController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Intervention\Image\ImageManagerStatic as Image;

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

Route::get('/', [WargaController::class, 'beritaShow']);
Route::get('/viewLogin', function () {
    return view('v_login');
})->name('login');
Route::get('/viewLoginAdmin', function () {
    return view('v_login_admin');
});
Route::get('/viewRegister', function () {
    return view('v_register');
});

Route::post('/register', [AuthController::class, 'registerAkun']);
Route::post('/loginWarga', [AuthController::class, 'loginWarga']);
Route::post('/loginAdmin', [AuthController::class, 'loginAdmin']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/logoutAdmin', [AuthController::class, 'logoutAdmin']);
// Route::get('/aksesWarga', [WargaController::class, 'aksesWarga']);
Route::get('/password/forgot', [AuthController::class, 'showForgotForm'])->name('forgot.password.form');
Route::post('/password/forgot', [AuthController::class, 'sendResetLink'])->name('forgot.password.link');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('reset.password.form');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('reset.password');
Route::get('/berita/detail/{id}', [WargaController::class, 'detailBerita']);
Route::get('/berita/list/detail/{id}', [WargaController::class, 'detailListBerita']);
Route::get('/berita/list', [WargaController::class, 'listBerita']);


Route::group(['middleware' => ['auth:user_warga']], function () {
    Route::get('/beranda', [WargaController::class, 'beranda']);
    Route::get('/beranda/berita/detail/{id}', [WargaController::class, 'detailBeritaHome']);
    Route::get('/beranda/berita/list', [WargaController::class, 'listBeritaBeranda']);
    Route::get('/beranda/berita/list/detail/{id}', [WargaController::class, 'detailListBeritaBeranda']);
    Route::get('/surat', [WargaController::class, 'surat']);
    Route::post('/surat/post', [WargaController::class, 'suratPost']);
    Route::get('/surat/history', [WargaController::class, 'suratHistory']);
    Route::put('/surat/ktp/revisi/{id}', [WargaController::class, 'ktpRevisi']);
    Route::put('/surat/kk/revisi/{id}', [WargaController::class, 'kkRevisi']);
    Route::get('/view/surat/{id}', [WargaController::class, 'viewSurat']);
});

Route::group(['middleware' => ['auth', 'cekRole:rt']], function () {
    Route::get('/dashboardRT', [RtController::class, 'dashboardRT']);
    Route::get('/rt/suratMasuk', [RtController::class, 'suratMasuk']);
    Route::get('/rt/surat/disetujui', [RtController::class, 'suratDisetujui']);
    Route::get('/rt/surat/ditolak', [RtController::class, 'suratDitolak']);
    Route::get('/rt/suratMasuk/accept/{id}', [RtController::class, 'acceptSurat']);
    Route::get('/rt/suratMasuk/reject/{id}', [RtController::class, 'rejectSurat']);
    Route::put('/rt/surat/note/{id}', [RtController::class, 'noteSurat']);
    Route::get('/view/surat/rt/{id}', [RtController::class, 'viewSuratRt']);
    Route::post('/rt/cari/surat', [RtController::class, 'cariSurat']);
});

Route::group(['middleware' => ['auth', 'cekRole:rw']], function () {
    Route::get('/dashboardRW', [RwController::class, 'dashboardRW']);
    Route::get('/berita', [RwController::class, 'berita']);
    Route::post('/berita/add', [RwController::class, 'beritaUpload']);
    Route::get('/berita/delete/{id}', [RwController::class, 'beritaDelete']);
    Route::put('/berita/edit/{id}', [RwController::class, 'beritaEdit']);
    Route::get('/rw/suratMasuk', [RwController::class, 'suratMasuk']);
    Route::get('/rw/surat/disetujui', [RwController::class, 'suratDisetujui']);
    Route::get('/rw/surat/ditolak', [RwController::class, 'suratDitolak']);
    Route::get('/rw/suratMasuk/accept/{id}', [RwController::class, 'acceptSurat']);
    Route::get('/rw/suratMasuk/reject/{id}', [RwController::class, 'rejectSurat']);
    Route::put('/rw/surat/note/{id}', [RwController::class, 'noteSurat']);
    Route::get('/view/surat/rw/{id}', [RwController::class, 'viewSuratRw']);
    Route::post('/rw/cari/surat', [RwController::class, 'cariSurat']);
});




Route::get('/test', function () {

    $img = Image::make('storage/file-surat/fqHctujwYyyy0Cmg9V4F2ibKX7FKQFB5whYDzJXx.jpg');
    $img->orientate()
        ->crop(3000, 2000, -260, 280)
        // ->invert()
        ->greyscale()
        ->contrast(100)
        // ->brightness(-20)
        // ->gamma(50)
        ->save('storage/file-surat/ktp14.jpg', 100);

    // $img = imagecreatefromjpeg('storage/file-surat/fqHctujwYyyy0Cmg9V4F2ibKX7FKQFB5whYDzJXx.jpg');
    // imagefilter($img, IMG_FILTER_GRAYSCALE); //first, convert to grayscale
    // imagefilter($img, IMG_FILTER_CONTRAST, -255); //then, apply a full contrast

    echo (new TesseractOCR(public_path(('storage/file-surat/ktp14.jpg'))))
        // ->lang('eng')
        ->psm(6)
        // ->oem(2)
        ->run();
});
