<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [MainController::class, 'index'])
                ->name('index')
                ->middleware('auth');
Route::post('/data/history', [MainController::class, 'getHistoryData'])
                ->name('history')
                ->middleware('auth');
Route::post('/data/main', [MainController::class, 'getMainData'])
                ->name('main')
                ->middleware('auth');
Route::post('/data/search/main', [MainController::class, 'getSearchMainData'])
                ->name('searchMain')
                ->middleware('auth');
Route::post('/data/search/history', [MainController::class, 'getSearchHistoryData'])
                ->name('searchHistory')
                ->middleware('auth');

Route::get('/car/add', [CarController::class, 'getAdd'])
                ->middleware('auth');
Route::post('/car/add', [CarController::class, 'add'])->name('add_car')
                ->middleware('auth');

Route::get('/car/details/{id}', [CarController::class, 'getDetails'])
                ->name('details')
                ->middleware('auth');

Route::get('/car/update/{id}', [CarController::class, 'getUpdate'])
                ->name('update_view')
                ->middleware('auth');
Route::post('/car/update/{id}', [CarController::class, 'update'])
                ->name('update')
                ->middleware('auth');


require __DIR__.'/auth.php';
