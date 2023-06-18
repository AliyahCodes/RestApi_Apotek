<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApotekController;



Route::get('/', [ApotekController::class, 'createToken']);