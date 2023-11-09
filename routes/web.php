<?php

use App\Models\Karyawan;
use App\Models\Departemen;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\MonitoringController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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


Route::middleware(['guest:karyawan'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/prosesLogin', [AuthController::class , 'prosesLogin'])->name('prosesLogin');
    Route::get('/logout', [AuthController::class , 'prosesLogout'])->name('prosesLogout');
    // register
Route::get('/register', [AuthController::class , 'register'])->name('register');
Route::post('/register', [AuthController::class , 'register_proses'])->name('register.proses');
});


Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('/home', [DashboardController::class , 'index'])->name('home');
    Route::get('/profile', [ProfileController::class , 'index'])->name('profile');
    Route::get('/history', [HistoryController::class , 'index'])->name('history');
    Route::get('/site', [SiteController::class , 'index'])->name('site');

    Route::get('/prosesLogout', [AuthController::class , 'prosesLogout'])->name('prosesLogout');
    // presensi
    Route::get('/presensi/create', [PresensiController::class, 'create'])->name('presensi.create');

    Route::post('/presensi/store', [PresensiController::class, 'store'])->name('presensi.store');
    Route::get('/edit-profile', [PresensiController::class ,'edit'])->name('edit-profile');
    Route::post('/update-profile', [PresensiController::class ,'update'])->name('update-profile');

});



// Define the 'loginAdmin' and 'prosesLoginadmin' routes for admin login
Route::get('/panel', function () {
    return view('auth.loginAdmin');
})->name('loginAdmin');

Route::post('/prosesLoginadmin', [AuthController::class, 'prosesLoginadmin'])->name('prosesLoginadmin');

// Use the 'auth:user' middleware for the 'adminpanel' route
Route::middleware(['auth:user'])->group(function () {
    Route::get('/panel/adminpanel', [DashboardController::class, 'indexadmin'])->name('adminpanel');
    Route::get('/logoutadmin', [AuthController::class, 'prosesLogoutadmin'])->name('prosesLogoutadmin');
    // bagian karyawan
    Route::get('/panel/datakaryawan', [KaryawanController::class, 'index'])->name('datakaryawan');
    Route::get('/panel/tambahkaryawan', [KaryawanController::class, 'tambahkaryawan'])->name('tambahkaryawan');
    Route::post('/karyawan/store', [KaryawanController::class ,'store'])->name('addkaryawanproses');
    Route::post('/karyawan/editkaryawan', [KaryawanController::class, 'editkaryawan'])->name('editkaryawan');
    Route::get('/panel/editdatakaryawan/{nik}', [KaryawanController::class, 'editdatakaryawan'])->name('editdatakaryawan');
    Route::post('/delete/{nik}', [KaryawanController::class, 'delete'])->name('delete');
    // bagian departemen
    Route::get('/departemen', [DepartemenController::class, 'index'])->name('departemen');
    Route::get('/tambahdepartemen', [DepartemenController::class, 'tambahdepartemen'])->name('tambahdepartemen');
    Route::post('/departemen/store', [DepartemenController::class ,'store'])->name('adddepartemenproses');
    Route::post('/departemen/editdepartemen', [DepartemenController::class, 'editdepartemen'])->name('editdepartemen');
    Route::delete('/delete/{id}', [DepartemenController::class, 'delete'])->name('delete_dept');
    Route::get('/editdatadepartemen/{id}', [DepartemenController::class, 'editdata'])->name('edit_dept');
    // bagian monitoring
    Route::get('/monitoring', [PresensiController::class, 'monitoring'])->name('monitoring');
    Route::post('/getpresensi', [PresensiController::class, 'getpresensi'])->name('getpresensi');


});

