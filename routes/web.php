<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('peta');
// });

// Route::get('/maps', function () {
//     return view('maps.leaflet');
// });

Route::resource('maps', MapController::class);

Route::resource('categories', CategoryController::class);

Route::resource('posts', PostController::class);
Route::get('posts/detail/{id}', [PostController::class, 'detail'])->name('posts.detail');

Route::resource('report', ReportController::class);
Route::get('report/lapor/{id}', [ReportController::class, 'report'])->name('report.add');
