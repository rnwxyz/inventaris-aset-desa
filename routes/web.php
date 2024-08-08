<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeralatanMesinController;
use App\Http\Controllers\BangunanLainnyaController;
use App\Http\Controllers\KendaraanBermotorController;

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
    // redirect ke halaman peralatan-mesin
    return redirect('/peralatan-mesin');
});


Route::get('/peralatan-mesin', [PeralatanMesinController::class, 'index'])->name('peralatan-mesin');
Route::post('/peralatan-mesin', [PeralatanMesinController::class, 'store'])->name('peralatan-mesin.store');
Route::delete('/peralatan-mesin/{id}', [PeralatanMesinController::class, 'delete'])->name('peralatan-mesin.delete');
Route::put('/peralatan-mesin/{id}', [PeralatanMesinController::class, 'update'])->name('peralatan-mesin.update');
Route::put('/peralatan-mesin/{id}', [PeralatanMesinController::class, 'update'])->name('peralatan-mesin.update');
Route::get('/peralatan-mesin/export', [PeralatanMesinController::class, 'export'])->name('peralatan-mesin.export');

Route::get('/bangunan-lainnya', [BangunanLainnyaController::class, 'index'])->name('bangunan-lainnya');
Route::post('/bangunan-lainnya', [BangunanLainnyaController::class, 'store'])->name('bangunan-lainnya.store');
Route::delete('/bangunan-lainnya/{id}', [BangunanLainnyaController::class, 'delete'])->name('bangunan-lainnya.delete');
Route::put('/bangunan-lainnya/{id}', [BangunanLainnyaController::class, 'update'])->name('bangunan-lainnya.update');
Route::put('/bangunan-lainnya/{id}', [BangunanLainnyaController::class, 'update'])->name('bangunan-lainnya.update');
Route::get('/bangunan-lainnya/export', [BangunanLainnyaController::class, 'export'])->name('bangunan-lainnya.export');

Route::get('/kendaraan-bermotor', [KendaraanBermotorController::class, 'index'])->name('kendaraan-bermotor');
Route::post('/kendaraan-bermotor', [KendaraanBermotorController::class, 'store'])->name('kendaraan-bermotor.store');
Route::delete('/kendaraan-bermotor/{id}', [KendaraanBermotorController::class, 'delete'])->name('kendaraan-bermotor.delete');
Route::put('/kendaraan-bermotor/{id}', [KendaraanBermotorController::class, 'update'])->name('kendaraan-bermotor.update');
Route::put('/kendaraan-bermotor/{id}', [KendaraanBermotorController::class, 'update'])->name('kendaraan-bermotor.update');
Route::get('/kendaraan-bermotor/export', [KendaraanBermotorController::class, 'export'])->name('kendaraan-bermotor.export');
