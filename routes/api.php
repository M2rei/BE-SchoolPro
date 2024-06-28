<?php

use App\Http\Controllers\AkademikController;
use App\Http\Controllers\AkreditasiController;
use App\Http\Controllers\GuruKaryawanController;
use App\Http\Controllers\GurumapelController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileSekolahController;
use App\Http\Controllers\SiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('indexxx', [LoginController::class, 'index']);
Route::post('login', [LoginController::class, 'login']);
Route::post('createuser', [LoginController::class, 'postuser'])->name('create.user');


Route::get('profile', [ProfileSekolahController::class, 'indexprofileschool'])->name('profile');
Route::post('postprofile', [ProfileSekolahController::class, 'postprofile'])->name('postprofile');

Route::put('updateprofileschool/{id}', [ProfileSekolahController::class, 'updateprofileschool'])->name('updateprofileschool');
Route::put('updatevisimisi/{id}', [ProfileSekolahController::class, 'updatevisimisi'])->name('updatevisimisi');
Route::put('updatesambutan/{id}', [ProfileSekolahController::class, 'updatesambutan'])->name('updateprofileschool');
Route::put('updatesejarah/{id}', [ProfileSekolahController::class, 'updatesejarah'])->name('updateprofileschool');



// Route gurukaryawan
Route::get('getguru', [GuruKaryawanController::class, 'indexGuru'])->name('getguru');
Route::get('getdetailguru/{id}', [GuruKaryawanController::class, 'indexdetailguru'])->name('getdetailguru');
Route::post('postguru', [GuruKaryawanController::class, 'postguru'])->name('postguru');
Route::put('updateguru/{id}', [GuruKaryawanController::class, 'updateguru'])->name('updateguru');
Route::delete('deleteguru/{id}', [GuruKaryawanController::class, 'deleteguru'])->name('deleteguru');

// Route guruMapel
Route::get('getgurumapel', [GurumapelController::class, 'indexgurumapel'])->name('getgurumapel');
Route::post('postgurumapel', [GurumapelController::class, 'postgurumapel'])->name('postgurumapel');
Route::put('updategurumapel/{id}', [GurumapelController::class, 'updategurumapel'])->name('updategurumapel');
Route::delete('deletegurumapel/{id}', [GurumapelController::class, 'deletegurumapel'])->name('deletegurumapel');


// Route matapelajaran
Route::get('getmatapelajaran', [GurumapelController::class, 'indexmatapelajaran'])->name('getmatapelajaran');
Route::post('postmatapelajaran', [GurumapelController::class, 'postmatapelajaran'])->name('postmatapelajaran');
Route::put('updatematapelajaran/{id}', [GurumapelController::class, 'updatematapelajaran'])->name('updatematapelajaran');
Route::delete('deletematapelajaran/{id}', [GurumapelController::class, 'deletematapelajaran'])->name('deletematapelajaran');

//Route jabatan_guru
Route::get('getjabatan', [GuruKaryawanController::class, 'indexjabatan'])->name('getjabatan');
Route::post('postjabatan', [GuruKaryawanController::class, 'postjabatan'])->name('postjabatan');
Route::put('upadatejabatan/{id}', [GuruKaryawanController::class, 'upadatejabatan'])->name('upadatejabatan');
Route::delete('deletejabatan/{id}', [GuruKaryawanController::class, 'deletejabatan'])->name('deletejabatan');

//Route siswa
Route::post('postsiswa', [SiswaController::class, 'postsiswa'])->name('postsiswa');;
Route::put('updatesiswa/{id}', [SiswaController::class, 'updatesiswa'])->name('updatesiswa');;
Route::delete('deletesiswa/{id}', [SiswaController::class, 'deletesiswa'])->name('deletesiswa');;

// Route Jurusan
Route::get('indexjurusan', [SiswaController::class, 'indexjurusan'])->name('getguru');;
Route::post('postjurusan', [SiswaController::class, 'postjurusan'])->name('postjurusan');;
Route::put('updatejurusan/{id}', [SiswaController::class, 'updatejurusan'])->name('updatejurusan');;
Route::delete('deletejurusan/{id}', [SiswaController::class, 'deletejurusan'])->name('deletejurusan');;

// Route galeri
Route::get('getgaleri', [ImageController::class, 'indexgaleri'])->name('getgaleri');
Route::get('getdetailgaleri/{id}', [ImageController::class, 'indexdetailgaleri'])->name('getdetailgaleri');
Route::post('postgaleri', [ImageController::class, 'postgaleri'])->name('postgaleri');;
Route::put('updategaleri/{id}', [ImageController::class, 'updategaleri'])->name('updategaleri');;
Route::delete('deletegaleri/{id}', [ImageController::class, 'deletegaleri'])->name('deletegaleri');;

// Route sarpras
Route::get('getsarpras', [ImageController::class, 'indexsarpras'])->name('getsarpras');
Route::get('getdetailsarpras/{id}', [ImageController::class, 'indexdetailsarpras'])->name('getdetailsarpras');
Route::post('postsarpras', [ImageController::class, 'postsarpras'])->name('postsarpras');;
Route::put('updatesarpras/{id}', [ImageController::class, 'updatesarpras'])->name('updatesarpras');;
Route::delete('deletesarpras/{id}', [ImageController::class, 'deletesarpras'])->name('deletesarpras');;

// Route Kurikulum
Route::get('getkurikulum', [KurikulumController::class, 'indexkurikulum'])->name('getkurikulum');
Route::post('postkurikulum', [KurikulumController::class, 'postkurikulum'])->name('postkurikulum');;
Route::put('updatekurikulum/{id}', [KurikulumController::class, 'updatekurikulum'])->name('updatekurikulum');;
Route::delete('deletekurikulum/{id}', [KurikulumController::class, 'deletekurikulum'])->name('deletekurikulum');;

// Route Akademik 
Route::get('getakademik', [AkademikController::class, 'indexakademik'])->name('getakademik');
Route::post('postakademik', [AkademikController::class, 'postakademik'])->name('postakademik');
Route::get('getdetailakademik/{id}', [AkademikController::class, 'indexdetailakademik'])->name('getdetailakademik');
Route::put('updateakademik/{id}', [AkademikController::class, 'updateakademik'])->name('updateakademik');;
Route::delete('deleteakademik/{id}', [AkademikController::class, 'deleteakademik'])->name('deleteakademik');;

//Route Akreditasi
Route::get('getakreditasi', [AkreditasiController::class, 'indexakreditasi'])->name('getakreditasi');
Route::get('getdetailakreditasi/{id}', [AkreditasiController::class, 'indexdetailakreditasi'])->name('getdetailakreditasi');
Route::post('postakreditasi', [AkreditasiController::class, 'postakreditasi'])->name('postakreditasi');;
Route::put('updateakreditasi/{id}', [AkreditasiController::class, 'updateakreditasi'])->name('updateakreditasi');;
Route::delete('deleteakreditasi/{id)', [AkreditasiController::class, 'deleteakreditasi'])->name('deleteakreditasi');;


// Route Informasi
Route::get('getinformasi', [InformasiController::class, 'indexinformasi'])->name('getinformasi');
Route::get('getdetailinformasi/{id}', [InformasiController::class, 'indexdetailinformasi'])->name('getdetailinformasi');
Route::post('postinformasi', [InformasiController::class, 'postinformasi'])->name('postinformasi');
Route::put('updateinformasi/{id}', [InformasiController::class, 'updateinformasi'])->name('updateinformasi');
Route::delete('deleteinformasi/{id}', [InformasiController::class, 'deleteinformasi'])->name('deleteinformasi');
