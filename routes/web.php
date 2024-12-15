<?php

use App\Http\Controllers\FincaIAController;
use Illuminate\Support\Facades\Route;

Route::post('/', [FincaIAController::class, 'processImages']);
