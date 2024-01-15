<?php

use App\Models\DaerahPenyangga;
use App\Models\PemanfaatanZonaBlok;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BmnController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\KphkController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BalaiController;
use App\Http\Controllers\HewanController;
use App\Http\Controllers\ResortController;
use App\Http\Controllers\ZonasiController;
use App\Http\Controllers\HonorerController;
use App\Http\Controllers\IupjswaController;
use App\Http\Controllers\JaslingController;
use App\Http\Controllers\pameranController;
use App\Http\Controllers\LkkhususController;
use App\Http\Controllers\TumbuhanController;
use App\Http\Controllers\ZonaBlokController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EkosistemController;
use App\Http\Controllers\KerjasamaController;
use App\Http\Controllers\DesaBinaanController;
use App\Http\Controllers\FungsionalController;
use App\Http\Controllers\JabatanSexController;
use App\Http\Controllers\PotensiAirController;
use App\Http\Controllers\DesainTapakController;
use App\Http\Controllers\PenetapanKKController;
use App\Http\Controllers\PotensiODTWAController;
use App\Http\Controllers\TenagaKarhutController;
use App\Http\Controllers\WilayahBogorController;
use App\Http\Controllers\FungsionalSexController;
use App\Http\Controllers\HasilEvaluasiController;
use App\Http\Controllers\KawasanKonserController;
use App\Http\Controllers\PenataanBatasController;
use App\Http\Controllers\PerburuanLiarController;
use App\Http\Controllers\PotensiKarbonController;
use App\Http\Controllers\PemanfaatanAirController;
use App\Http\Controllers\PembinaanUsahaController;
use App\Http\Controllers\PenebanganLiarController;
use App\Http\Controllers\PeralatanMesinController;
use App\Http\Controllers\PerencanaanPKKController;
use App\Http\Controllers\WilayahCianjurController;
use App\Http\Controllers\DaerahPenyanggaController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\KerjasamaTeknisController;
use App\Http\Controllers\PegawaiGolonganController;
use App\Http\Controllers\PenangananJenisController;
use App\Http\Controllers\PeralatanTanganController;
use App\Http\Controllers\WilayahSukabumiController;
use App\Http\Controllers\RekontruksiBatasController;
use App\Http\Controllers\RencanaRealisasiController;
use App\Http\Controllers\SaranaPengamatanController;
use App\Http\Controllers\TenagaPengamananController;
use App\Http\Controllers\PegawaiPendidikanController;
use App\Http\Controllers\PemeliharaanBatasController;
use App\Http\Controllers\PenangananPerkaraController;
use App\Http\Controllers\PerubahanFungsikkController;
use App\Http\Controllers\KemitraanKonservasiController;
use App\Http\Controllers\PemanfaatanZonaBlokController;
use App\Http\Controllers\PermasalahanKawasanController;
use App\Http\Controllers\FungsionalPendidikanController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\PerencanaanPemulihanController;
use App\Http\Controllers\PengambilanHasilHutanController;
use App\Http\Controllers\PeralatanTransportasiController;
use App\Http\Controllers\TenagaPengamananSatkerController;
use App\Http\Controllers\TenagaPengamananHutanKKController;

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

Route::get('/admin/maps', function () {
    return view('admin.maps.index');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('auth.forgotpassword');
Route::get('/forgotpassword', function () {
    return view('auth.forgotpassword');
})->middleware('auth')->name('password.request');
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [AuthController::class, 'profil'])->name('profil');
    // Start Tahun
    Route::get('/desaintapak', [DesainTapakController::class, 'index'])->name('desaintapak.index');
    Route::get('/desaintapak/create', [DesainTapakController::class, 'create'])->name('desaintapak.create');
    Route::post('/desaintapak', [DesainTapakController::class, 'store'])->name('desaintapak.store');
    Route::get('/desaintapak/{desaintapak}/edit', [DesainTapakController::class, 'edit'])->name('desaintapak.edit');
    Route::put('/desaintapak/{desaintapak}', [DesainTapakController::class, 'update'])->name('desaintapak.update');
    Route::delete('/desaintapak/{desaintapak}', [DesainTapakController::class, 'destroy'])->name('desaintapak.destroy');
    Route::get('/desaintapak/export', [DesainTapakController::class, 'exportToExcel'])->name('desaintapak.export');

    Route::get('/kemitraankonservasi', [KemitraanKonservasiController::class, 'index'])->name('kemitraankonservasi.index');
    Route::get('/kemitraankonservasi/create', [KemitraanKonservasiController::class, 'create'])->name('kemitraankonservasi.create');
    Route::post('/kemitraankonservasi', [KemitraanKonservasiController::class, 'store'])->name('kemitraankonservasi.store');
    Route::get('/kemitraankonservasi/{kemitraankonservasi}/edit', [KemitraanKonservasiController::class, 'edit'])->name('kemitraankonservasi.edit');
    Route::put('/kemitraankonservasi/{kemitraankonservasi}', [KemitraanKonservasiController::class, 'update'])->name('kemitraankonservasi.update');
    Route::delete('/kemitraankonservasi/{kemitraankonservasi}', [KemitraanKonservasiController::class, 'destroy'])->name('kemitraankonservasi.destroy');
    Route::get('/kemitraankonservasi/export', [KemitraanKonservasiController::class, 'exportToExcel'])->name('kemitraankonservasi.export');

    Route::get('/perencanaanpemulihan', [PerencanaanPemulihanController::class, 'index'])->name('perencanaanpemulihan.index');
    Route::get('/perencanaanpemulihan/create', [PerencanaanPemulihanController::class, 'create'])->name('perencanaanpemulihan.create');
    Route::post('/perencanaanpemulihan', [PerencanaanPemulihanController::class, 'store'])->name('perencanaanpemulihan.store');
    Route::get('/perencanaanpemulihan/{perencanaanpemulihan}/edit', [PerencanaanPemulihanController::class, 'edit'])->name('perencanaanpemulihan.edit');
    Route::put('/perencanaanpemulihan/{perencanaanpemulihan}', [PerencanaanPemulihanController::class, 'update'])->name('perencanaanpemulihan.update');
    Route::delete('/perencanaanpemulihan/{perencanaanpemulihan}', [PerencanaanPemulihanController::class, 'destroy'])->name('perencanaanpemulihan.destroy');
    Route::get('/perencanaanpemulihan/export', [PerencanaanPemulihanController::class, 'exportToExcel'])->name('perencanaanpemulihan.export');

    Route::get('/rencanarealisasi', [RencanaRealisasiController::class, 'index'])->name('rencanarealisasi.index');
    Route::get('/rencanarealisasi/create', [RencanaRealisasiController::class, 'create'])->name('rencanarealisasi.create');
    Route::post('/rencanarealisasi', [RencanaRealisasiController::class, 'store'])->name('rencanarealisasi.store');
    Route::get('/rencanarealisasi/{rencanarealisasi}/edit', [RencanaRealisasiController::class, 'edit'])->name('rencanarealisasi.edit');
    Route::put('/rencanarealisasi/{rencanarealisasi}', [RencanaRealisasiController::class, 'update'])->name('rencanarealisasi.update');
    Route::delete('/rencanarealisasi/{rencanarealisasi}', [RencanaRealisasiController::class, 'destroy'])->name('rencanarealisasi.destroy');
    Route::get('/rencanarealisasi/export', [RencanaRealisasiController::class, 'exportToExcel'])->name('rencanarealisasi.export');

    Route::get('/daerahpenyangga', [DaerahPenyanggaController::class, 'index'])->name('daerahpenyangga.index');
    Route::get('/daerahpenyangga/create', [DaerahPenyanggaController::class, 'create'])->name('daerahpenyangga.create');
    Route::post('/daerahpenyangga', [DaerahPenyanggaController::class, 'store'])->name('daerahpenyangga.store');
    Route::get('/daerahpenyangga/{daerahpenyangga}/edit', [DaerahPenyanggaController::class, 'edit'])->name('daerahpenyangga.edit');
    Route::put('/daerahpenyangga/{daerahpenyangga}', [DaerahPenyanggaController::class, 'update'])->name('daerahpenyangga.update');
    Route::delete('/daerahpenyangga/{daerahpenyangga}', [DaerahPenyanggaController::class, 'destroy'])->name('daerahpenyangga.destroy');
    Route::get('/daerahpenyangga/export', [DaerahPenyanggaController::class, 'exportToExcel'])->name('daerahpenyangga.export');

    Route::get('/desabinaans', [DesaBinaanController::class, 'index'])->name('desabinaans.index');
    Route::get('/desabinaans/create', [DesaBinaanController::class, 'create'])->name('desabinaans.create');
    Route::post('/desabinaans', [DesaBinaanController::class, 'store'])->name('desabinaans.store');
    Route::get('/desabinaans/{desabinaans}/edit', [DesaBinaanController::class, 'edit'])->name('desabinaans.edit');
    Route::put('/desabinaans/{desabinaans}', [DesaBinaanController::class, 'update'])->name('desabinaans.update');
    Route::delete('/desabinaans/{desabinaans}', [DesaBinaanController::class, 'destroy'])->name('desabinaans.destroy');
    Route::get('/desabinaans/export', [DesaBinaanController::class, 'exportToExcel'])->name('desabinaans.export');

    Route::get('/zonablok', [ZonaBlokController::class, 'index'])->name('zonablok.index');
    Route::get('/zonablok/create', [ZonaBlokController::class, 'create'])->name('zonablok.create');
    Route::post('/zonablok', [ZonaBlokController::class, 'store'])->name('zonablok.store');
    Route::get('/zonablok/{zonablok}/edit', [ZonaBlokController::class, 'edit'])->name('zonablok.edit');
    Route::put('/zonablok/{zonablok}', [ZonaBlokController::class, 'update'])->name('zonablok.update');
    Route::delete('/zonablok/{zonablok}', [ZonaBlokController::class, 'destroy'])->name('zonablok.destroy');
    Route::get('/zonablok/export', [ZonaBlokController::class, 'exportToExcel'])->name('zonablok.export');

    Route::get('/pemanfaatanzona', [PemanfaatanZonaBlokController::class, 'index'])->name('pemanfaatanzona.index');
    Route::get('/pemanfaatanzona/create', [PemanfaatanZonaBlokController::class, 'create'])->name('pemanfaatanzona.create');
    Route::post('/pemanfaatanzona', [PemanfaatanZonaBlokController::class, 'store'])->name('pemanfaatanzona.store');
    Route::get('/pemanfaatanzona/{pemanfaatanzona}/edit', [PemanfaatanZonaBlokController::class, 'edit'])->name('pemanfaatanzona.edit');
    Route::put('/pemanfaatanzona/{pemanfaatanzona}', [PemanfaatanZonaBlokController::class, 'update'])->name('pemanfaatanzona.update');
    Route::delete('/pemanfaatanzona/{pemanfaatanzona}', [PemanfaatanZonaBlokController::class, 'destroy'])->name('pemanfaatanzona.destroy');
    Route::get('/pemanfaatanzona/export', [PemanfaatanZonaBlokController::class, 'exportToExcel'])->name('pemanfaatanzona.export');
    // End Tahun
    Route::get('pembinaanusaha', [PembinaanUsahaController::class, 'index'])->name('pembinaanusaha.index');
    Route::get('pembinaanusaha/triwulan/{triwulan}', [PembinaanUsahaController::class, 'index'])->name('pembinaanusaha.index.triwulan');
    Route::get('/pembinaanusaha/export',  [PembinaanUsahaController::class, 'exportToExcel'])->name('pembinaanusaha.export');
    Route::get('pembinaanusaha/create/{triwulan}', [PembinaanUsahaController::class, 'create'])->name('pembinaanusaha.create');
    Route::post('pembinaanusaha', [PembinaanUsahaController::class, 'store'])->name('pembinaanusaha.store');
    Route::get('/pembinaanusaha/{triwulan}/{id}/edit', [PembinaanUsahaController::class, 'edit'])->name('pembinaanusaha.edit');
    Route::put('/pembinaanusaha/{triwulan}/{id}/update', [PembinaanUsahaController::class, 'update'])->name('pembinaanusaha.update');
    Route::delete('/pembinaanusaha/{triwulan}/{id}/destroy', [PembinaanUsahaController::class, 'destroy'])->name('pembinaanusaha.destroy');



    Route::get('permasalahankawasan', [PermasalahanKawasanController::class, 'index'])->name('permasalahankawasan.index');
    Route::get('permasalahankawasan/triwulan/{triwulan}', [PermasalahanKawasanController::class, 'index'])->name('permasalahankawasan.index.triwulan');
    Route::get('/permasalahankawasan/export',  [PermasalahanKawasanController::class, 'exportToExcel'])->name('permasalahankawasan.export');
    Route::get('permasalahankawasan/create/{triwulan}', [PermasalahanKawasanController::class, 'create'])->name('permasalahankawasan.create');
    Route::post('permasalahankawasan', [PermasalahanKawasanController::class, 'store'])->name('permasalahankawasan.store');
    Route::get('/permasalahankawasan/{triwulan}/{id}/edit', [PermasalahanKawasanController::class, 'edit'])->name('permasalahankawasan.edit');
    Route::put('/permasalahankawasan/{triwulan}/{id}/update', [PermasalahanKawasanController::class, 'update'])->name('permasalahankawasan.update');
    Route::delete('/permasalahankawasan/{triwulan}/{id}/destroy', [PermasalahanKawasanController::class, 'destroy'])->name('permasalahankawasan.destroy');


    Route::get('penanganan_perkara', [PenangananPerkaraController::class, 'index'])->name('penanganan_perkara.index');
    Route::get('penanganan_perkara/triwulan/{triwulan}', [PenangananPerkaraController::class, 'index'])->name('penanganan_perkara.index.triwulan');
    Route::get('/penanganan_perkara/export',  [PenangananPerkaraController::class, 'exportToExcel'])->name('penanganan_perkara.export');
    Route::get('penanganan_perkara/create/{triwulan}', [PenangananPerkaraController::class, 'create'])->name('penanganan_perkara.create');
    Route::post('penanganan_perkara', [PenangananPerkaraController::class, 'store'])->name('penanganan_perkara.store');
    Route::get('/penanganan_perkara/{triwulan}/{id}/edit', [PenangananPerkaraController::class, 'edit'])->name('penanganan_perkara.edit');
    Route::put('/penanganan_perkara/{triwulan}/{id}/update', [PenangananPerkaraController::class, 'update'])->name('penanganan_perkara.update');
    Route::delete('/penanganan_perkara/{triwulan}/{id}/destroy', [PenangananPerkaraController::class, 'destroy'])->name('penanganan_perkara.destroy');

    //
    Route::get('tenaga_pengamanan_hutan', [TenagaPengamananHutanKKController::class, 'index'])->name('tenaga_pengamanan_hutan.index');
    Route::get('tenaga_pengamanan_hutan/triwulan/{triwulan}', [TenagaPengamananHutanKKController::class, 'index'])->name('tenaga_pengamanan_hutan.index.triwulan');
    Route::get('/tenaga_pengamanan_hutan/export',  [TenagaPengamananHutanKKController::class, 'exportToExcel'])->name('tenaga_pengamanan_hutan.export');
    Route::get('tenaga_pengamanan_hutan/create/{triwulan}', [TenagaPengamananHutanKKController::class, 'create'])->name('tenaga_pengamanan_hutan.create');
    Route::post('tenaga_pengamanan_hutan', [TenagaPengamananHutanKKController::class, 'store'])->name('tenaga_pengamanan_hutan.store');
    Route::get('/tenaga_pengamanan_hutan/{triwulan}/{id}/edit', [TenagaPengamananHutanKKController::class, 'edit'])->name('tenaga_pengamanan_hutan.edit');
    Route::put('/tenaga_pengamanan_hutan/{triwulan}/{id}/update', [TenagaPengamananHutanKKController::class, 'update'])->name('tenaga_pengamanan_hutan.update');
    Route::delete('/tenaga_pengamanan_hutan/{triwulan}/{id}/destroy', [TenagaPengamananHutanKKController::class, 'destroy'])->name('tenaga_pengamanan_hutan.destroy');

    //
    Route::get('tenagapengamansatker', [TenagaPengamananSatkerController::class, 'index'])->name('tenagapengamansatker.index');
    Route::get('tenagapengamansatker/triwulan/{triwulan}', [TenagaPengamananSatkerController::class, 'index'])->name('tenagapengamansatker.index.triwulan');
    Route::get('/tenagapengamansatker/export',  [TenagaPengamananSatkerController::class, 'exportToExcel'])->name('tenagapengamansatker.export');
    Route::get('tenagapengamansatker/create/{triwulan}', [TenagaPengamananSatkerController::class, 'create'])->name('tenagapengamansatker.create');
    Route::post('tenagapengamansatker', [TenagaPengamananSatkerController::class, 'store'])->name('tenagapengamansatker.store');
    Route::get('/tenagapengamansatker/{triwulan}/{id}/edit', [TenagaPengamananSatkerController::class, 'edit'])->name('tenagapengamansatker.edit');
    Route::put('/tenagapengamansatker/{triwulan}/{id}/update', [TenagaPengamananSatkerController::class, 'update'])->name('tenagapengamansatker.update');
    Route::delete('/tenagapengamansatker/{triwulan}/{id}/destroy', [TenagaPengamananSatkerController::class, 'destroy'])->name('tenagapengamansatker.destroy');

    //
    Route::get('tenagakarhut', [TenagaKarhutController::class, 'index'])->name('tenagakarhut.index');
    Route::get('tenagakarhut/triwulan/{triwulan}', [TenagaKarhutController::class, 'index'])->name('tenagakarhut.index.triwulan');
    Route::get('/tenagakarhut/export',  [TenagaKarhutController::class, 'exportToExcel'])->name('tenagakarhut.export');
    Route::get('tenagakarhut/create/{triwulan}', [TenagaKarhutController::class, 'create'])->name('tenagakarhut.create');
    Route::post('tenagakarhut', [TenagaKarhutController::class, 'store'])->name('tenagakarhut.store');
    Route::get('/tenagakarhut/{triwulan}/{id}/edit', [TenagaKarhutController::class, 'edit'])->name('tenagakarhut.edit');
    Route::put('/tenagakarhut/{triwulan}/{id}/update', [TenagaKarhutController::class, 'update'])->name('tenagakarhut.update');
    Route::delete('/tenagakarhut/{triwulan}/{id}/destroy', [TenagaKarhutController::class, 'destroy'])->name('tenagakarhut.destroy');

    //
    Route::get('/lkkhususpetaall', [LkkhususController::class, 'showAllDataOnMap'])->name('lkkhusus.petaall');
    Route::get('/lkkhususpeta/{triwulan}/{id}{latitude}/{longitude}',  [LkkhususController::class, 'showPeta'])->name('lkkhusus.peta');
    Route::get('lkkhusus', [LkkhususController::class, 'index'])->name('lkkhusus.index');
    Route::get('lkkhusus/triwulan/{triwulan}', [LkkhususController::class, 'index'])->name('lkkhusus.index.triwulan');
    Route::get('/lkkhusus/export',  [LkkhususController::class, 'exportToExcel'])->name('lkkhusus.export');
    Route::get('lkkhusus/create/{triwulan}', [LkkhususController::class, 'create'])->name('lkkhusus.create');
    Route::post('lkkhusus', [LkkhususController::class, 'store'])->name('lkkhusus.store');
    Route::get('/lkkhusus/{triwulan}/{id}/edit', [LkkhususController::class, 'edit'])->name('lkkhusus.edit');
    Route::put('/lkkhusus/{triwulan}/{id}/update', [LkkhususController::class, 'update'])->name('lkkhusus.update');
    Route::delete('/lkkhusus/{triwulan}/{id}/destroy', [LkkhususController::class, 'destroy'])->name('lkkhusus.destroy');

    //
    Route::get('penetapankk', [PenetapanKKController::class, 'index'])->name('penetapankk.index');
    Route::get('penetapankk/triwulan/{triwulan}', [PenetapanKKController::class, 'index'])->name('penetapankk.index.triwulan');
    Route::get('/penetapankk/export',  [PenetapanKKController::class, 'exportToExcel'])->name('penetapankk.export');
    Route::get('penetapankk/create/{triwulan}', [PenetapanKKController::class, 'create'])->name('penetapankk.create');
    Route::post('penetapankk', [PenetapanKKController::class, 'store'])->name('penetapankk.store');
    Route::get('/penetapankk/{triwulan}/{id}/edit', [PenetapanKKController::class, 'edit'])->name('penetapankk.edit');
    Route::put('/penetapankk/{triwulan}/{id}/update', [PenetapanKKController::class, 'update'])->name('penetapankk.update');
    Route::delete('/penetapankk/{triwulan}/{id}/destroy', [PenetapanKKController::class, 'destroy'])->name('penetapankk.destroy');


    Route::get('/potensiodtwapetaall', [PotensiODTWAController::class, 'showAllDataOnMap'])->name('potensiodtwa.petaall');
    Route::get('/potensiodtwapeta/{triwulan}/{id}{latitude}/{longitude}',  [PotensiODTWAController::class, 'showPeta'])->name('potensiodtwa.peta');
    Route::get('potensiodtwa', [PotensiODTWAController::class, 'index'])->name('potensiodtwa.index');
    Route::get('potensiodtwa/triwulan/{triwulan}', [PotensiODTWAController::class, 'index'])->name('potensiodtwa.index.triwulan');
    Route::get('/potensiodtwa/export',  [PotensiODTWAController::class, 'exportToExcel'])->name('potensiodtwa.export');
    Route::get('potensiodtwa/create/{triwulan}', [PotensiODTWAController::class, 'create'])->name('potensiodtwa.create');
    Route::post('potensiodtwa', [PotensiODTWAController::class, 'store'])->name('potensiodtwa.store');
    Route::get('/potensiodtwa/{triwulan}/{id}/edit', [PotensiODTWAController::class, 'edit'])->name('potensiodtwa.edit');
    Route::put('/potensiodtwa/{triwulan}/{id}/update', [PotensiODTWAController::class, 'update'])->name('potensiodtwa.update');
    Route::delete('/potensiodtwa/{triwulan}/{id}/destroy', [PotensiODTWAController::class, 'destroy'])->name('potensiodtwa.destroy');

    //
    Route::get('iupjswa', [IupjswaController::class, 'index'])->name('iupjswa.index');
    Route::get('iupjswa/triwulan/{triwulan}', [IupjswaController::class, 'index'])->name('iupjswa.index.triwulan');
    Route::get('/iupjswa/export',  [IupjswaController::class, 'exportToExcel'])->name('iupjswa.export');
    Route::get('iupjswa/create/{triwulan}', [IupjswaController::class, 'create'])->name('iupjswa.create');
    Route::post('iupjswa', [IupjswaController::class, 'store'])->name('iupjswa.store');
    Route::get('/iupjswa/{triwulan}/{id}/edit', [IupjswaController::class, 'edit'])->name('iupjswa.edit');
    Route::put('/iupjswa/{triwulan}/{id}/update', [IupjswaController::class, 'update'])->name('iupjswa.update');
    Route::delete('/iupjswa/{triwulan}/{id}/destroy', [IupjswaController::class, 'destroy'])->name('iupjswa.destroy');

    //
    Route::get('/potensiairpetaall', [PotensiAirController::class, 'showAllDataOnMap'])->name('potensiair.petaall');
    Route::get('/potensiairpeta/{triwulan}/{id}{latitude}/{longitude}',  [PotensiAirController::class, 'showPeta'])->name('potensiair.peta');
    Route::get('potensiair', [PotensiAirController::class, 'index'])->name('potensiair.index');
    Route::get('potensiair/triwulan/{triwulan}', [PotensiAirController::class, 'index'])->name('potensiair.index.triwulan');
    Route::get('/potensiair/export',  [PotensiAirController::class, 'exportToExcel'])->name('potensiair.export');
    Route::get('potensiair/create/{triwulan}', [PotensiAirController::class, 'create'])->name('potensiair.create');
    Route::post('potensiair', [PotensiAirController::class, 'store'])->name('potensiair.store');
    Route::get('/potensiair/{triwulan}/{id}/edit', [PotensiAirController::class, 'edit'])->name('potensiair.edit');
    Route::put('/potensiair/{triwulan}/{id}/update', [PotensiAirController::class, 'update'])->name('potensiair.update');
    Route::delete('/potensiair/{triwulan}/{id}/destroy', [PotensiAirController::class, 'destroy'])->name('potensiair.destroy');

    //
    Route::get('potensikarbon', [PotensiKarbonController::class, 'index'])->name('potensikarbon.index');
    Route::get('potensikarbon/triwulan/{triwulan}', [PotensiKarbonController::class, 'index'])->name('potensikarbon.index.triwulan');
    Route::get('/potensikarbon/export',  [PotensiKarbonController::class, 'exportToExcel'])->name('potensikarbon.export');
    Route::get('potensikarbon/create/{triwulan}', [PotensiKarbonController::class, 'create'])->name('potensikarbon.create');
    Route::post('potensikarbon', [PotensiKarbonController::class, 'store'])->name('potensikarbon.store');
    Route::get('/potensikarbon/{triwulan}/{id}/edit', [PotensiKarbonController::class, 'edit'])->name('potensikarbon.edit');
    Route::put('/potensikarbon/{triwulan}/{id}/update', [PotensiKarbonController::class, 'update'])->name('potensikarbon.update');
    Route::delete('/potensikarbon/{triwulan}/{id}/destroy', [PotensiKarbonController::class, 'destroy'])->name('potensikarbon.destroy');

    //
    Route::get('/get-kecamatan/{kabupaten_id}', [PemanfaatanAirController::class, 'getKecamatan']);
    Route::get('/get-desa/{kecamatan_id}', [PemanfaatanAirController::class, 'getDesa']);
    Route::get('pemanfaatanair', [PemanfaatanAirController::class, 'index'])->name('pemanfaatanair.index');
    Route::get('pemanfaatanair/triwulan/{triwulan}', [PemanfaatanAirController::class, 'index'])->name('pemanfaatanair.index.triwulan');
    Route::get('/pemanfaatanair/export',  [PemanfaatanAirController::class, 'exportToExcel'])->name('pemanfaatanair.export');
    Route::get('pemanfaatanair/create/{triwulan}', [PemanfaatanAirController::class, 'create'])->name('pemanfaatanair.create');
    Route::post('pemanfaatanair', [PemanfaatanAirController::class, 'store'])->name('pemanfaatanair.store');
    Route::get('/pemanfaatanair/{triwulan}/{id}/edit', [PemanfaatanAirController::class, 'edit'])->name('pemanfaatanair.edit');
    Route::put('/pemanfaatanair/{triwulan}/{id}/update', [PemanfaatanAirController::class, 'update'])->name('pemanfaatanair.update');
    Route::delete('/pemanfaatanair/{triwulan}/{id}/destroy', [PemanfaatanAirController::class, 'destroy'])->name('pemanfaatanair.destroy');

    //
    Route::get('jasling', [JaslingController::class, 'index'])->name('jasling.index');
    Route::get('jasling/triwulan/{triwulan}', [JaslingController::class, 'index'])->name('jasling.index.triwulan');
    Route::get('/jasling/export',  [JaslingController::class, 'exportToExcel'])->name('jasling.export');
    Route::get('jasling/create/{triwulan}', [JaslingController::class, 'create'])->name('jasling.create');
    Route::post('jasling', [JaslingController::class, 'store'])->name('jasling.store');
    Route::get('/jasling/{triwulan}/{id}/edit', [JaslingController::class, 'edit'])->name('jasling.edit');
    Route::put('/jasling/{triwulan}/{id}/update', [JaslingController::class, 'update'])->name('jasling.update');
    Route::delete('/jasling/{triwulan}/{id}/destroy', [JaslingController::class, 'destroy'])->name('jasling.destroy');

    //
    Route::get('pegawaipendidikan', [PegawaiPendidikanController::class, 'index'])->name('pegawaipendidikan.index');
    Route::get('pegawaipendidikan/semester/{semester}', [PegawaiPendidikanController::class, 'index'])->name('pegawaipendidikan.index.semester');
    Route::get('/pegawaipendidikan/export',  [PegawaiPendidikanController::class, 'exportToExcel'])->name('pegawaipendidikan.export');
    Route::get('pegawaipendidikan/create/{semester}', [PegawaiPendidikanController::class, 'create'])->name('pegawaipendidikan.create');
    Route::post('pegawaipendidikan', [PegawaiPendidikanController::class, 'store'])->name('pegawaipendidikan.store');
    Route::get('/pegawaipendidikan/{semester}/{id}/edit', [PegawaiPendidikanController::class, 'edit'])->name('pegawaipendidikan.edit');
    Route::put('/pegawaipendidikan/{semester}/{id}/update', [PegawaiPendidikanController::class, 'update'])->name('pegawaipendidikan.update');
    Route::delete('/pegawaipendidikan/{semester}/{id}/destroy', [PegawaiPendidikanController::class, 'destroy'])->name('pegawaipendidikan.destroy');

    //
    Route::get('kawasankonservasi', [KawasanKonserController::class, 'index'])->name('kawasankonservasi.index');
    Route::get('kawasankonservasi/semester/{semester}', [KawasanKonserController::class, 'index'])->name('kawasankonservasi.index.semester');
    Route::get('/kawasankonservasi/export', [KawasanKonserController::class, 'exportToExcel'])->name('kawasankonservasi.export');
    Route::get('kawasankonservasi/create/{semester}', [KawasanKonserController::class, 'create'])->name('kawasankonservasi.create');
    Route::post('kawasankonservasi', [KawasanKonserController::class, 'store'])->name('kawasankonservasi.store');
    Route::get('/kawasankonservasi/{semester}/{id}/edit', [KawasanKonserController::class, 'edit'])->name('kawasankonservasi.edit');
    Route::put('/kawasankonservasi/{semester}/{id}/update', [KawasanKonserController::class, 'update'])->name('kawasankonservasi.update');
    Route::delete('/kawasankonservasi/{semester}/{id}/destroy', [KawasanKonserController::class, 'destroy'])->name('kawasankonservasi.destroy');

    //
    Route::get('perencanaanpkk', [PerencanaanPKKController::class, 'index'])->name('perencanaanpkk.index');
    Route::get('perencanaanpkk/semester/{semester}', [PerencanaanPKKController::class, 'index'])->name('perencanaanpkk.index.semester');
    Route::get('/perencanaanpkk/export', [PerencanaanPKKController::class, 'exportToExcel'])->name('perencanaanpkk.export');
    Route::get('perencanaanpkk/create/{semester}', [PerencanaanPKKController::class, 'create'])->name('perencanaanpkk.create');
    Route::post('perencanaanpkk', [PerencanaanPKKController::class, 'store'])->name('perencanaanpkk.store');
    Route::get('/perencanaanpkk/{semester}/{id}/edit', [PerencanaanPKKController::class, 'edit'])->name('perencanaanpkk.edit');
    Route::put('/perencanaanpkk/{semester}/{id}/update', [PerencanaanPKKController::class, 'update'])->name('perencanaanpkk.update');
    Route::delete('/perencanaanpkk/{semester}/{id}/destroy', [PerencanaanPKKController::class, 'destroy'])->name('perencanaanpkk.destroy');

    //
    Route::get('penataanbatas', [PenataanBatasController::class, 'index'])->name('penataanbatas.index');
    Route::get('penataanbatas/semester/{semester}', [PenataanBatasController::class, 'index'])->name('penataanbatas.index.semester');
    Route::get('/penataanbatas/export', [PenataanBatasController::class, 'exportToExcel'])->name('penataanbatas.export');
    Route::get('penataanbatas/create/{semester}', [PenataanBatasController::class, 'create'])->name('penataanbatas.create');
    Route::post('penataanbatas', [PenataanBatasController::class, 'store'])->name('penataanbatas.store');
    Route::get('/penataanbatas/{semester}/{id}/edit', [PenataanBatasController::class, 'edit'])->name('penataanbatas.edit');
    Route::put('/penataanbatas/{semester}/{id}/update', [PenataanBatasController::class, 'update'])->name('penataanbatas.update');
    Route::delete('/penataanbatas/{semester}/{id}/destroy', [PenataanBatasController::class, 'destroy'])->name('penataanbatas.destroy');

    //
    Route::get('rekontruksibatas', [RekontruksiBatasController::class, 'index'])->name('rekontruksibatas.index');
    Route::get('rekontruksibatas/semester/{semester}', [RekontruksiBatasController::class, 'index'])->name('rekontruksibatas.index.semester');
    Route::get('/rekontruksibatas/export', [RekontruksiBatasController::class, 'exportToExcel'])->name('rekontruksibatas.export');
    Route::get('rekontruksibatas/create/{semester}', [RekontruksiBatasController::class, 'create'])->name('rekontruksibatas.create');
    Route::post('rekontruksibatas', [RekontruksiBatasController::class, 'store'])->name('rekontruksibatas.store');
    Route::get('/rekontruksibatas/{semester}/{id}/edit', [RekontruksiBatasController::class, 'edit'])->name('rekontruksibatas.edit');
    Route::put('/rekontruksibatas/{semester}/{id}/update', [RekontruksiBatasController::class, 'update'])->name('rekontruksibatas.update');
    Route::delete('/rekontruksibatas/{semester}/{id}/destroy', [RekontruksiBatasController::class, 'destroy'])->name('rekontruksibatas.destroy');

    //
    Route::get('saranapengamatan', [SaranaPengamatanController::class, 'index'])->name('saranapengamatan.index');
    Route::get('saranapengamatan/semester/{semester}', [SaranaPengamatanController::class, 'index'])->name('saranapengamatan.index.semester');
    Route::get('/saranapengamatan/export', [SaranaPengamatanController::class, 'exportToExcel'])->name('saranapengamatan.export');
    Route::get('saranapengamatan/create/{semester}', [SaranaPengamatanController::class, 'create'])->name('saranapengamatan.create');
    Route::post('saranapengamatan', [SaranaPengamatanController::class, 'store'])->name('saranapengamatan.store');
    Route::get('/saranapengamatan/{semester}/{id}/edit', [SaranaPengamatanController::class, 'edit'])->name('saranapengamatan.edit');
    Route::put('/saranapengamatan/{semester}/{id}/update', [SaranaPengamatanController::class, 'update'])->name('saranapengamatan.update');
    Route::delete('/saranapengamatan/{semester}/{id}/destroy', [SaranaPengamatanController::class, 'destroy'])->name('saranapengamatan.destroy');

    //
    Route::get('pemeliharaanbatas', [PemeliharaanBatasController::class, 'index'])->name('pemeliharaanbatas.index');
    Route::get('pemeliharaanbatas/semester/{semester}', [PemeliharaanBatasController::class, 'index'])->name('pemeliharaanbatas.index.semester');
    Route::get('/pemeliharaanbatas/export', [PemeliharaanBatasController::class, 'exportToExcel'])->name('pemeliharaanbatas.export');
    Route::get('pemeliharaanbatas/create/{semester}', [PemeliharaanBatasController::class, 'create'])->name('pemeliharaanbatas.create');
    Route::post('pemeliharaanbatas', [PemeliharaanBatasController::class, 'store'])->name('pemeliharaanbatas.store');
    Route::get('/pemeliharaanbatas/{semester}/{id}/edit', [PemeliharaanBatasController::class, 'edit'])->name('pemeliharaanbatas.edit');
    Route::put('/pemeliharaanbatas/{semester}/{id}/update', [PemeliharaanBatasController::class, 'update'])->name('pemeliharaanbatas.update');
    Route::delete('/pemeliharaanbatas/{semester}/{id}/destroy', [PemeliharaanBatasController::class, 'destroy'])->name('pemeliharaanbatas.destroy');

    //
    Route::get('peralatantangan', [PeralatanTanganController::class, 'index'])->name('peralatantangan.index');
    Route::get('peralatantangan/semester/{semester}', [PeralatanTanganController::class, 'index'])->name('peralatantangan.index.semester');
    Route::get('/peralatantangan/export', [PeralatanTanganController::class, 'exportToExcel'])->name('peralatantangan.export');
    Route::get('peralatantangan/create/{semester}', [PeralatanTanganController::class, 'create'])->name('peralatantangan.create');
    Route::post('peralatantangan', [PeralatanTanganController::class, 'store'])->name('peralatantangan.store');
    Route::get('/peralatantangan/{semester}/{id}/edit', [PeralatanTanganController::class, 'edit'])->name('peralatantangan.edit');
    Route::put('/peralatantangan/{semester}/{id}/update', [PeralatanTanganController::class, 'update'])->name('peralatantangan.update');
    Route::delete('/peralatantangan/{semester}/{id}/destroy', [PeralatanTanganController::class, 'destroy'])->name('peralatantangan.destroy');

    //
    Route::get('peralatantransportasi', [PeralatanTransportasiController::class, 'index'])->name('peralatantransportasi.index');
    Route::get('peralatantransportasi/semester/{semester}', [PeralatanTransportasiController::class, 'index'])->name('peralatantransportasi.index.semester');
    Route::get('/peralatantransportasi/export', [PeralatanTransportasiController::class, 'exportToExcel'])->name('peralatantransportasi.export');
    Route::get('peralatantransportasi/create/{semester}', [PeralatanTransportasiController::class, 'create'])->name('peralatantransportasi.create');
    Route::post('peralatantransportasi', [PeralatanTransportasiController::class, 'store'])->name('peralatantransportasi.store');
    Route::get('/peralatantransportasi/{semester}/{id}/edit', [PeralatanTransportasiController::class, 'edit'])->name('peralatantransportasi.edit');
    Route::put('/peralatantransportasi/{semester}/{id}/update', [PeralatanTransportasiController::class, 'update'])->name('peralatantransportasi.update');
    Route::delete('/peralatantransportasi/{semester}/{id}/destroy', [PeralatanTransportasiController::class, 'destroy'])->name('peralatantransportasi.destroy');

    //
    Route::get('peralatanmesin', [PeralatanMesinController::class, 'index'])->name('peralatanmesin.index');
    Route::get('peralatanmesin/semester/{semester}', [PeralatanMesinController::class, 'index'])->name('peralatanmesin.index.semester');
    Route::get('/peralatanmesin/export', [PeralatanMesinController::class, 'exportToExcel'])->name('peralatanmesin.export');
    Route::get('peralatanmesin/create/{semester}', [PeralatanMesinController::class, 'create'])->name('peralatanmesin.create');
    Route::post('peralatanmesin', [PeralatanMesinController::class, 'store'])->name('peralatanmesin.store');
    Route::get('/peralatanmesin/{semester}/{id}/edit', [PeralatanMesinController::class, 'edit'])->name('peralatanmesin.edit');
    Route::put('/peralatanmesin/{semester}/{id}/update', [PeralatanMesinController::class, 'update'])->name('peralatanmesin.update');
    Route::delete('/peralatanmesin/{semester}/{id}/destroy', [PeralatanMesinController::class, 'destroy'])->name('peralatanmesin.destroy');

    // 
    Route::get('penangananjenispetaall', [PenangananJenisController::class, 'showAllDataOnMap'])->name('penangananjenis.petaall');
    Route::get('/penangananjenispeta/{semester}/{id}{latitude}/{longitude}',  [PenangananJenisController::class, 'showPeta'])->name('penangananjenis.peta');
    Route::get('penangananjenis', [PenangananJenisController::class, 'index'])->name('penangananjenis.index');
    Route::get('penangananjenis/semester/{semester}', [PenangananJenisController::class, 'index'])->name('penangananjenis.index.semester');
    Route::get('/penangananjenis/export', [PenangananJenisController::class, 'exportToExcel'])->name('penangananjenis.export');
    Route::get('penangananjenis/create/{semester}', [PenangananJenisController::class, 'create'])->name('penangananjenis.create');
    Route::post('penangananjenis', [PenangananJenisController::class, 'store'])->name('penangananjenis.store');
    Route::get('/penangananjenis/{semester}/{id}/edit', [PenangananJenisController::class, 'edit'])->name('penangananjenis.edit');
    Route::put('/penangananjenis/{semester}/{id}/update', [PenangananJenisController::class, 'update'])->name('penangananjenis.update');
    Route::delete('/penangananjenis/{semester}/{id}/destroy', [PenangananJenisController::class, 'destroy'])->name('penangananjenis.destroy');

    //
    Route::get('hasilevaluasi', [HasilEvaluasiController::class, 'index'])->name('hasilevaluasi.index');
    Route::get('hasilevaluasi/semester/{semester}', [HasilEvaluasiController::class, 'index'])->name('hasilevaluasi.index.semester');
    Route::get('/hasilevaluasi/export', [HasilEvaluasiController::class, 'exportToExcel'])->name('hasilevaluasi.export');
    Route::get('hasilevaluasi/create/{semester}', [HasilEvaluasiController::class, 'create'])->name('hasilevaluasi.create');
    Route::post('hasilevaluasi', [HasilEvaluasiController::class, 'store'])->name('hasilevaluasi.store');
    Route::get('/hasilevaluasi/{semester}/{id}/edit', [HasilEvaluasiController::class, 'edit'])->name('hasilevaluasi.edit');
    Route::put('/hasilevaluasi/{semester}/{id}/update', [HasilEvaluasiController::class, 'update'])->name('hasilevaluasi.update');
    Route::delete('/hasilevaluasi/{semester}/{id}/destroy', [HasilEvaluasiController::class, 'destroy'])->name('hasilevaluasi.destroy');

    //
    Route::get('perubahanfungsikk', [PerubahanFungsikkController::class, 'index'])->name('perubahanfungsikk.index');
    Route::get('perubahanfungsikk/semester/{semester}', [PerubahanFungsikkController::class, 'index'])->name('perubahanfungsikk.index.semester');
    Route::get('/perubahanfungsikk/export', [PerubahanFungsikkController::class, 'exportToExcel'])->name('perubahanfungsikk.export');
    Route::get('perubahanfungsikk/create/{semester}', [PerubahanFungsikkController::class, 'create'])->name('perubahanfungsikk.create');
    Route::post('perubahanfungsikk', [PerubahanFungsikkController::class, 'store'])->name('perubahanfungsikk.store');
    Route::get('/perubahanfungsikk/{semester}/{id}/edit', [PerubahanFungsikkController::class, 'edit'])->name('perubahanfungsikk.edit');
    Route::put('/perubahanfungsikk/{semester}/{id}/update', [PerubahanFungsikkController::class, 'update'])->name('perubahanfungsikk.update');
    Route::delete('/perubahanfungsikk/{semester}/{id}/destroy', [PerubahanFungsikkController::class, 'destroy'])->name('perubahanfungsikk.destroy');

    //
    Route::get('ekosistem', [EkosistemController::class, 'index'])->name('ekosistem.index');
    Route::get('ekosistem/semester/{semester}', [EkosistemController::class, 'index'])->name('ekosistem.index.semester');
    Route::get('/ekosistem/export', [EkosistemController::class, 'exportToExcel'])->name('ekosistem.export');
    Route::get('ekosistem/create/{semester}', [EkosistemController::class, 'create'])->name('ekosistem.create');
    Route::post('ekosistem', [EkosistemController::class, 'store'])->name('ekosistem.store');
    Route::get('/ekosistem/{semester}/{id}/edit', [EkosistemController::class, 'edit'])->name('ekosistem.edit');
    Route::put('/ekosistem/{semester}/{id}/update', [EkosistemController::class, 'update'])->name('ekosistem.update');
    Route::delete('/ekosistem/{semester}/{id}/destroy', [EkosistemController::class, 'destroy'])->name('ekosistem.destroy');

    //
    Route::get('kphk', [KphkController::class, 'index'])->name('kphk.index');
    Route::get('kphk/semester/{semester}', [KphkController::class, 'index'])->name('kphk.index.semester');
    Route::get('/kphk/export', [KphkController::class, 'exportToExcel'])->name('kphk.export');
    Route::get('kphk/create/{semester}', [KphkController::class, 'create'])->name('kphk.create');
    Route::post('kphk', [KphkController::class, 'store'])->name('kphk.store');
    Route::get('/kphk/{semester}/{id}/edit', [KphkController::class, 'edit'])->name('kphk.edit');
    Route::put('/kphk/{semester}/{id}/update', [KphkController::class, 'update'])->name('kphk.update');
    Route::delete('/kphk/{semester}/{id}/destroy', [KphkController::class, 'destroy'])->name('kphk.destroy');

    //
    Route::get('pameran', [Pamerancontroller::class, 'index'])->name('pameran.index');
    Route::get('pameran/semester/{semester}', [Pamerancontroller::class, 'index'])->name('pameran.index.semester');
    Route::get('/pameran/export', [Pamerancontroller::class, 'exportToExcel'])->name('pameran.export');
    Route::get('pameran/create/{semester}', [Pamerancontroller::class, 'create'])->name('pameran.create');
    Route::post('pameran', [Pamerancontroller::class, 'store'])->name('pameran.store');
    Route::get('/pameran/{semester}/{id}/edit', [Pamerancontroller::class, 'edit'])->name('pameran.edit');
    Route::put('/pameran/{semester}/{id}/update', [Pamerancontroller::class, 'update'])->name('pameran.update');
    Route::delete('/pameran/{semester}/{id}/destroy', [Pamerancontroller::class, 'destroy'])->name('pameran.destroy');

    //
    Route::get('pegawaigolongan', [PegawaiGolonganController::class, 'index'])->name('pegawaigolongan.index');
    Route::get('pegawaigolongan/semester/{semester}', [PegawaiGolonganController::class, 'index'])->name('pegawaigolongan.index.semester');
    Route::get('/pegawaigolongan/export', [PegawaiGolonganController::class, 'exportToExcel'])->name('pegawaigolongan.export');
    Route::get('pegawaigolongan/create/{semester}', [PegawaiGolonganController::class, 'create'])->name('pegawaigolongan.create');
    Route::post('pegawaigolongan', [PegawaiGolonganController::class, 'store'])->name('pegawaigolongan.store');
    Route::get('/pegawaigolongan/{semester}/{id}/edit', [PegawaiGolonganController::class, 'edit'])->name('pegawaigolongan.edit');
    Route::put('/pegawaigolongan/{semester}/{id}/update', [PegawaiGolonganController::class, 'update'])->name('pegawaigolongan.update');
    Route::delete('/pegawaigolongan/{semester}/{id}/destroy', [PegawaiGolonganController::class, 'destroy'])->name('pegawaigolongan.destroy');

    //
    Route::get('fungsionalsex', [FungsionalSexController::class, 'index'])->name('fungsionalsex.index');
    Route::get('fungsionalsex/semester/{semester}', [FungsionalSexController::class, 'index'])->name('fungsionalsex.index.semester');
    Route::get('/fungsionalsex/export', [FungsionalSexController::class, 'exportToExcel'])->name('fungsionalsex.export');
    Route::get('fungsionalsex/create/{semester}', [FungsionalSexController::class, 'create'])->name('fungsionalsex.create');
    Route::post('fungsionalsex', [FungsionalSexController::class, 'store'])->name('fungsionalsex.store');
    Route::get('/fungsionalsex/{semester}/{id}/edit', [FungsionalSexController::class, 'edit'])->name('fungsionalsex.edit');
    Route::put('/fungsionalsex/{semester}/{id}/update', [FungsionalSexController::class, 'update'])->name('fungsionalsex.update');
    Route::delete('/fungsionalsex/{semester}/{id}/destroy', [FungsionalSexController::class, 'destroy'])->name('fungsionalsex.destroy');

    //
    Route::get('jabatansex', [JabatanSexController::class, 'index'])->name('jabatansex.index');
    Route::get('jabatansex/semester/{semester}', [JabatanSexController::class, 'index'])->name('jabatansex.index.semester');
    Route::get('/jabatansex/export', [JabatanSexController::class, 'exportToExcel'])->name('jabatansex.export');
    Route::get('jabatansex/create/{semester}', [JabatanSexController::class, 'create'])->name('jabatansex.create');
    Route::post('jabatansex', [JabatanSexController::class, 'store'])->name('jabatansex.store');
    Route::get('/jabatansex/{semester}/{id}/edit', [JabatanSexController::class, 'edit'])->name('jabatansex.edit');
    Route::put('/jabatansex/{semester}/{id}/update', [JabatanSexController::class, 'update'])->name('jabatansex.update');
    Route::delete('/jabatansex/{semester}/{id}/destroy', [JabatanSexController::class, 'destroy'])->name('jabatansex.destroy');

    //
    Route::get('bmn', [BmnController::class, 'index'])->name('bmn.index');
    Route::get('bmn/semester/{semester}', [BmnController::class, 'index'])->name('bmn.index.semester');
    Route::get('/bmn/export', [BmnController::class, 'exportToExcel'])->name('bmn.export');
    Route::get('bmn/create/{semester}', [BmnController::class, 'create'])->name('bmn.create');
    Route::post('bmn', [BmnController::class, 'store'])->name('bmn.store');
    Route::get('/bmn/{semester}/{id}/edit', [BmnController::class, 'edit'])->name('bmn.edit');
    Route::put('/bmn/{semester}/{id}/update', [BmnController::class, 'update'])->name('bmn.update');
    Route::delete('/bmn/{semester}/{id}/destroy', [BmnController::class, 'destroy'])->name('bmn.destroy');

    //
    Route::get('honorer', [HonorerController::class, 'index'])->name('honorer.index');
    Route::get('honorer/semester/{semester}', [HonorerController::class, 'index'])->name('honorer.index.semester');
    Route::get('/honorer/export', [HonorerController::class, 'exportToExcel'])->name('honorer.export');
    Route::get('honorer/create/{semester}', [HonorerController::class, 'create'])->name('honorer.create');
    Route::post('honorer', [HonorerController::class, 'store'])->name('honorer.store');
    Route::get('/honorer/{semester}/{id}/edit', [HonorerController::class, 'edit'])->name('honorer.edit');
    Route::put('/honorer/{semester}/{id}/update', [HonorerController::class, 'update'])->name('honorer.update');
    Route::delete('/honorer/{semester}/{id}/destroy', [HonorerController::class, 'destroy'])->name('honorer.destroy');

    //
    Route::get('zonasi', [ZonasiController::class, 'index'])->name('zonasi.index');
    Route::get('zonasi/semester/{semester}', [ZonasiController::class, 'index'])->name('zonasi.index.semester');
    Route::get('/zonasi/export', [ZonasiController::class, 'exportToExcel'])->name('zonasi.export');
    Route::get('zonasi/create/{semester}', [ZonasiController::class, 'create'])->name('zonasi.create');
    Route::post('zonasi', [ZonasiController::class, 'store'])->name('zonasi.store');
    Route::get('/zonasi/{semester}/{id}/edit', [ZonasiController::class, 'edit'])->name('zonasi.edit');
    Route::put('/zonasi/{semester}/{id}/update', [ZonasiController::class, 'update'])->name('zonasi.update');
    Route::delete('/zonasi/{semester}/{id}/destroy', [ZonasiController::class, 'destroy'])->name('zonasi.destroy');

    //
    Route::get('kerjasama', [KerjasamaController::class, 'index'])->name('kerjasama.index');
    Route::get('kerjasama/semester/{semester}', [KerjasamaController::class, 'index'])->name('kerjasama.index.semester');
    Route::get('/kerjasama/export', [KerjasamaController::class, 'exportToExcel'])->name('kerjasama.export');
    Route::get('kerjasama/create/{semester}', [KerjasamaController::class, 'create'])->name('kerjasama.create');
    Route::post('kerjasama', [KerjasamaController::class, 'store'])->name('kerjasama.store');
    Route::get('/kerjasama/{semester}/{id}/edit', [KerjasamaController::class, 'edit'])->name('kerjasama.edit');
    Route::put('/kerjasama/{semester}/{id}/update', [KerjasamaController::class, 'update'])->name('kerjasama.update');
    Route::delete('/kerjasama/{semester}/{id}/destroy', [KerjasamaController::class, 'destroy'])->name('kerjasama.destroy');

    //
    Route::get('fungsional', [FungsionalController::class, 'index'])->name('fungsional.index');
    Route::get('fungsional/semester/{semester}', [FungsionalController::class, 'index'])->name('fungsional.index.semester');
    Route::get('/fungsional/export', [FungsionalController::class, 'exportToExcel'])->name('fungsional.export');
    Route::get('fungsional/create/{semester}', [FungsionalController::class, 'create'])->name('fungsional.create');
    Route::post('fungsional', [FungsionalController::class, 'store'])->name('fungsional.store');
    Route::get('/fungsional/{semester}/{id}/edit', [FungsionalController::class, 'edit'])->name('fungsional.edit');
    Route::put('/fungsional/{semester}/{id}/update', [FungsionalController::class, 'update'])->name('fungsional.update');
    Route::delete('/fungsional/{semester}/{id}/destroy', [FungsionalController::class, 'destroy'])->name('fungsional.destroy');

    //
    Route::get('fungsionalpendidikan', [FungsionalPendidikanController::class, 'index'])->name('fungsionalpendidikan.index');
    Route::get('fungsionalpendidikan/semester/{semester}', [FungsionalPendidikanController::class, 'index'])->name('fungsionalpendidikan.index.semester');
    Route::get('/fungsionalpendidikan/export', [FungsionalPendidikanController::class, 'exportToExcel'])->name('fungsionalpendidikan.export');
    Route::get('fungsionalpendidikan/create/{semester}', [FungsionalPendidikanController::class, 'create'])->name('fungsionalpendidikan.create');
    Route::post('fungsionalpendidikan', [FungsionalPendidikanController::class, 'store'])->name('fungsionalpendidikan.store');
    Route::get('/fungsionalpendidikan/{semester}/{id}/edit', [FungsionalPendidikanController::class, 'edit'])->name('fungsionalpendidikan.edit');
    Route::put('/fungsionalpendidikan/{semester}/{id}/update', [FungsionalPendidikanController::class, 'update'])->name('fungsionalpendidikan.update');
    Route::delete('/fungsionalpendidikan/{semester}/{id}/destroy', [FungsionalPendidikanController::class, 'destroy'])->name('fungsionalpendidikan.destroy');
    //
    Route::get('kerjasamateknis', [KerjasamaTeknisController::class, 'index'])->name('kerjasamateknis.index');
    Route::get('kerjasamateknis/semester/{semester}', [KerjasamaTeknisController::class, 'index'])->name('kerjasamateknis.index.semester');
    Route::get('/kerjasamateknis/export', [KerjasamaTeknisController::class, 'exportToExcel'])->name('kerjasamateknis.export');
    Route::get('kerjasamateknis/create/{semester}', [KerjasamaTeknisController::class, 'create'])->name('kerjasamateknis.create');
    Route::post('kerjasamateknis', [KerjasamaTeknisController::class, 'store'])->name('kerjasamateknis.store');
    Route::get('/kerjasamateknis/{semester}/{id}/edit', [KerjasamaTeknisController::class, 'edit'])->name('kerjasamateknis.edit');
    Route::put('/kerjasamateknis/{semester}/{id}/update', [KerjasamaTeknisController::class, 'update'])->name('kerjasamateknis.update');
    Route::delete('/kerjasamateknis/{semester}/{id}/destroy', [KerjasamaTeknisController::class, 'destroy'])->name('kerjasamateknis.destroy');

    // Rute untuk Admin
    Route::middleware(['checkrole:Admin'])->group(function () {
        //masterdata
        Route::resource('user', UserController::class);
        Route::resource('kabupaten', KabupatenController::class);
        Route::resource('kecamatan', KecamatanController::class);
        Route::resource('desa', DesaController::class);
        Route::resource('resort', ResortController::class);
        //master data

        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });

    // Rute untuk Balai
    Route::middleware(['checkrole:Balai'])->group(function () {

        Route::get('/balai/settings', [BalaiController::class, 'settings'])->name('balai.settings');
    });

    // Rute untuk Wilayah Cianjur
    Route::middleware(['checkrole:Wilayah Cianjur'])->group(function () {
        // Tambahkan rute-rute wilayah Cianjur sesuai kebutuhan
        Route::get('/wilayah-cianjur/settings', [WilayahCianjurController::class, 'settings'])->name('wilayah-cianjur.settings');
    });

    // Rute untuk Wilayah Sukabumi
    Route::middleware(['checkrole:Wilayah Sukabumi'])->group(function () {
        // Tambahkan rute-rute wilayah Sukabumi sesuai kebutuhan
        Route::get('/wilayah-sukabumi/settings', [WilayahSukabumiController::class, 'settings'])->name('wilayah-sukabumi.settings');
    });

    // Rute untuk Wilayah Bogor
    Route::middleware(['checkrole:Wilayah Bogor'])->group(function () {
        // Tambahkan rute-rute wilayah Bogor sesuai kebutuhan
        Route::get('/wilayah-bogor/settings', [WilayahBogorController::class, 'settings'])->name('wilayah-bogor.settings');
    });
});
Route::prefix('')->group(function () {

    // Route::get('/', function () {
    //     return view('admin.layouts.app');
    // });


    // Route::get('/pengambilanhasilhutan/peta', [PengambilanHasilHutanController::class, 'showMap'])->name('pengambilanhasilhutan.peta');
    // Route::get('/pengambilanhasilhutan', [PengambilanHasilHutanController::class, 'index'])->name('pengambilanhasilhutan.index');
    // Route::get('/pengambilanhasilhutan/create', [PengambilanHasilHutanController::class, 'create'])->name('pengambilanhasilhutan.create');
    // Route::post('/pengambilanhasilhutan', [PengambilanHasilHutanController::class, 'store'])->name('pengambilanhasilhutan.store');
    // Route::get('/pengambilanhasilhutan/{pengambilanHasilHutan}/edit', [PengambilanHasilHutanController::class, 'edit'])->name('pengambilanhasilhutan.edit');
    // Route::put('/pengambilanhasilhutan/{pengambilanHasilHutan}', [PengambilanHasilHutanController::class, 'update'])->name('pengambilanhasilhutan.update');
    // Route::delete('/pengambilanhasilhutan/{pengambilanHasilHutan}', [PengambilanHasilHutanController::class, 'destroy'])->name('pengambilanhasilhutan.destroy');

    // Route::get('/penebanganliar/peta', [PenebanganLiarController::class, 'showMap'])->name('penebanganliar.peta');
    // Route::get('/penebanganliar', [PenebanganLiarController::class, 'index'])->name('penebanganliar.index');
    // Route::get('/penebanganliar/create', [PenebanganLiarController::class, 'create'])->name('penebanganliar.create');
    // Route::post('/penebanganliar', [PenebanganLiarController::class, 'store'])->name('penebanganliar.store');
    // Route::get('/penebanganliar/{penebanganliar}/edit', [PenebanganLiarController::class, 'edit'])->name('penebanganliar.edit');
    // Route::put('/penebanganliar/{penebanganliar}', [PenebanganLiarController::class, 'update'])->name('penebanganliar.update');
    // Route::delete('/penebanganliar/{penebanganliar}', [PenebanganLiarController::class, 'destroy'])->name('penebanganliar.destroy');

    // Route::get('/perburuanliar/peta', [PerburuanLiarController::class, 'showMap'])->name('perburuanliar.peta');
    // Route::get('/perburuanliar', [PerburuanLiarController::class, 'index'])->name('perburuanliar.index');
    // Route::get('/perburuanliar/create', [PerburuanLiarController::class, 'create'])->name('perburuanliar.create');
    // Route::post('/perburuanliar', [PerburuanLiarController::class, 'store'])->name('perburuanliar.store');
    // Route::get('/perburuanliar/{perburuanliar}/edit', [PerburuanLiarController::class, 'edit'])->name('perburuanliar.edit');
    // Route::put('/perburuanliar/{perburuanliar}', [PerburuanLiarController::class, 'update'])->name('perburuanliar.update');
    // Route::delete('/perburuanliar/{perburuanliar}', [PerburuanLiarController::class, 'destroy'])->name('perburuanliar.destroy');

    // Route::get('/tumbuhan/peta', [TumbuhanController::class, 'showMap'])->name('tumbuhan.peta');
    // Route::get('/tumbuhan', [TumbuhanController::class, 'index'])->name('tumbuhan.index');
    // Route::get('/tumbuhan/create', [TumbuhanController::class, 'create'])->name('tumbuhan.create');
    // Route::post('/tumbuhan', [TumbuhanController::class, 'store'])->name('tumbuhan.store');
    // Route::get('/tumbuhan/{tumbuhan}/edit', [TumbuhanController::class, 'edit'])->name('tumbuhan.edit');
    // Route::put('/tumbuhan/{tumbuhan}', [TumbuhanController::class, 'update'])->name('tumbuhan.update');
    // Route::delete('/tumbuhan/{tumbuhan}', [TumbuhanController::class, 'destroy'])->name('tumbuhan.destroy');

    // Route::get('/hewan/peta', [HewanController::class, 'showMap'])->name('hewan.peta');
    // Route::get('/hewan', [HewanController::class, 'index'])->name('hewan.index');
    // Route::get('/hewan/create', [HewanController::class, 'create'])->name('hewan.create');
    // Route::post('/hewan', [HewanController::class, 'store'])->name('hewan.store');
    // Route::get('/hewan/{hewan}/edit', [HewanController::class, 'edit'])->name('hewan.edit');
    // Route::put('/hewan/{hewan}', [HewanController::class, 'update'])->name('hewan.update');
    // Route::delete('/hewan/{hewan}', [HewanController::class, 'destroy'])->name('hewan.destroy');
});
