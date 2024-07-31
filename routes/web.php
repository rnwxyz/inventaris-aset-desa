<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeralatanMesinController;

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
