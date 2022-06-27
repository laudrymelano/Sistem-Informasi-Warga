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

Route::post('/register/send', [AuthController::class, 'registerWarga']);
Route::get('/foto', [AuthController::class, 'foto']);


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
    Route::get('/searchKeperluanSurat', [WargaController::class, 'searchKeperluanSurat']);
    Route::get('/view/surat/{id}', [WargaController::class, 'viewSurat']);
    Route::get('/evoting', [WargaController::class, 'eVoting']);
    Route::get('/evoting/vote/{id}/{id_voting}', [WargaController::class, 'voteCalon']);
    Route::get('/evoting/selesai', [WargaController::class, 'voteSelesai']);
});

Route::group(['middleware' => ['auth', 'cekRole:rt']], function () {
    Route::get('/dashboardRT', [RtController::class, 'dashboardRT']);
    Route::post('/rt/getDataDashboard', [RtController::class, 'getDataDashboard']);
    Route::get('/rt/data/warga', [RtController::class, 'dataWarga']);
    Route::get('/rt/suratMasuk', [RtController::class, 'suratMasuk']);
    Route::get('/rt/surat/disetujui', [RtController::class, 'suratDisetujui']);
    Route::get('/rt/surat/ditolak', [RtController::class, 'suratDitolak']);
    Route::get('/rt/suratMasuk/accept/{id}', [RtController::class, 'acceptSurat']);
    Route::get('/rt/suratMasuk/reject/{id}', [RtController::class, 'rejectSurat']);
    Route::put('/rt/surat/note/{id}', [RtController::class, 'noteSurat']);
    Route::get('/view/surat/rt/{id}', [RtController::class, 'viewSuratRt']);
    Route::post('/rt/cari/surat', [RtController::class, 'cariSurat']);
    Route::get('/rt/voting', [RtController::class, 'voting']);
    Route::post('/rt/voting/add', [RtController::class, 'addVoting']);
    Route::get('/voting/delete/{id}', [RtController::class, 'deleteVoting']);
    Route::put('/voting/edit/{id}', [RtController::class, 'editVoting']);
    Route::get('/voting/open/{id}', [RtController::class, 'showVoting']);
    Route::get('/voting/close/{id}', [RtController::class, 'closeVoting']);
    Route::get('/rt/voting/calon', [RtController::class, 'calon']);
    Route::get('/rt/voting/calon/show/{id}', [RtController::class, 'periodeCalon']);
    Route::post('/voting/add/calon', [RtController::class, 'addCalon']);
    Route::get('/voting/delete/calon/{id}', [RtController::class, 'deleteCalon']);
    Route::put('/voting/calon/edit/{id}', [RtController::class, 'editCalon']);
    Route::get('/rt/voting/hasil', [RtController::class, 'hasilVoting']);
    Route::get('/rt/print/voting/{id}', [RtController::class, 'printVoting']);
});

Route::group(['middleware' => ['auth', 'cekRole:rw']], function () {
    Route::get('/dashboardRW', [RwController::class, 'dashboardRW']);
    Route::get('/rw/akun/rt', [RwController::class, 'akunRT']);
    Route::post('/rw/add/akun', [RwController::class, 'addAkun']);
    Route::put('/rw/akun/edit/{id}', [RwController::class, 'editAkun']);
    Route::get('/akun/delete/{id}', [RwController::class, 'deleteAkun']);
    Route::get('/rw/data/warga', [RwController::class, 'dataWarga']);
    Route::post('/rw/getDataWarga', [RwController::class, 'getDataWarga']);
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
    Route::get('/rw/dashboard/chart/{id}', [RwController::class, 'dashboardChart']);
});

Route::get('/camera', function () {
    return view('v_tester_camera');
});

// Route::get('/e-voting', function () {
//     return view('warga.v_e-voting');
// });


Route::get('/test', function () {

    // $imgWidth = Image::make('storage/file-surat/ktp test1.jpeg')->width();
    // $imgHeight = Image::make('storage/file-surat/ktp test1.jpeg')->height();
    $img = Image::make('storage/file-surat/test(1).jpeg');
    $img->rotate(90)
        ->orientate()
        ->fit(1920, 1080)
        ->crop(1200, 700, 0, 260)
        // ->invert()
        // ->greyscale()
        // ->contrast(100)
        // ->brightness(-20)
        // ->gamma(50)
        ->save('storage/file-surat/ktptesthasil.jpeg', 100);

    header('Content-Type: image/jpeg');

    // Open image and get dimensions
    $im = imagecreatefromjpeg("storage/file-surat/ktptesthasil.jpeg");
    $w = imagesx($im);
    $h = imagesy($im);

    // Convert to greyscale
    imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
    imagefilter($im, IMG_FILTER_GRAYSCALE);
    // imagefilter($im, IMG_FILTER_SELECTIVE_BLUR);
    // imagefilter($im, IMG_FILTER_EMBOSS);
    imagepng($im, "grey.png");              // DEBUG only

    // Allocate a new palette image to hold the b&w output
    $out = imagecreate($w, $h);
    // Allocate b&w palette entries
    $black = imagecolorallocate($out, 0, 0, 0);
    $white = imagecolorallocate($out, 255, 255, 255);

    // Iterate over all pixels, thresholding to pure b&w
    for ($x = 0; $x < $w; $x++) {
        for ($y = 0; $y < $h; $y++) {
            // Get current color
            $index  = imagecolorat($im, $x, $y);
            $grey   = imagecolorsforindex($im, $index)['red'];
            $arraygray[] = $grey;
        }
    }
    $data = 0;
    $jml_data = count($arraygray);
    foreach ($arraygray as $item) {
        $data += $item;
    }
    for ($x = 0; $x < $w; $x++) {
        for ($y = 0; $y < $h; $y++) {
            // Get current color
            $index  = imagecolorat($im, $x, $y);
            $grey   = imagecolorsforindex($im, $index)['red'];
            // Set pixel white if below threshold - don't bother settting black as image is initially black anyway
            if ($grey <= $data / $jml_data - 40) {
                imagesetpixel($out, $x, $y, $black);
            } else {
                imagesetpixel($out, $x, $y, $white);
            }
        }
    }
    imagepng($out, "storage/file-surat/ktptesthasil.png");

    // $img = Image::make('storage/file-surat/ktptesthasil.png');
    // $img->sharpen(100)
    //     ->save('storage/file-surat/ktptesthasil.png', 100);

    // echo (new TesseractOCR(public_path(('result2.png'))))
    //     // ->lang('eng')
    //     // ->psm(6)
    //     // ->oem(2)
    //     ->run();

    // $imf = imagecreatefrompng("storage/file-surat/ktptesthasil.png");
    // imagefilter($imf, IMG_FILTER_EMBOSS);
    // imagefilter($imf, IMG_FILTER_EDGEDETECT);
    // imagepng($imf, "storage/file-surat/ktptesthasil.png");

    $lihat = new TesseractOCR(public_path(('storage/file-surat/ktptesthasil.png')));
    // ->lang('eng')

    // ->oem(2)
    $lihatstring = $lihat
        // ->lang('ind')
        // ->psm(6)
        // ->oem(3)
        ->dpi(300)
        ->run();
    // $lihatarray = explode(chr(10), $lihatstring);
    // $lihatarray = preg_split('/\r\n|\n\r|\r|\n/', $lihatstring);


    // var_dump($lihatstring);

    function splitNewLine($text)
    {
        $code = preg_replace('/\n$/', '', preg_replace('/^\n/', '', preg_replace('/[\r\n]+/', "\n", $text)));
        return explode("\n", $code);
    }

    $lihatarray = splitNewLine($lihatstring);

    return view('v_tester_ocr', ['lihat' => $lihatarray]);
});
