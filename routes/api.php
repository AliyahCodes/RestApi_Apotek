<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApotekController;

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

Route::get('/apoteks', [ApotekController::class, 'index']);
Route::post('/apoteks/store', [ApotekController::class, 'store']);
Route::get('/apoteks/{id}', [ApotekController::class, 'show']);
Route::patch('/apoteks/update/{id}', [ApotekController::class, 'update']);
Route::delete('/apoteks/delete/{id}', [ApotekController::class, 'destroy']);

Route::get('/apoteks/search/{apoteker}', [ApotekController::class, 'search']);

Route::get('/apoteks/trash/all', [ApotekController::class, 'trash']);
Route::get('/apoteks/trash/restore/{id}', [ApotekController::class, 'restore']);
Route::get('/apoteks/trash/permanent/{id}', [ApotekController::class, 'permanentDelete']);







