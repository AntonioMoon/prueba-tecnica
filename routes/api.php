<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;

Route::get('/countries', [CountryController::class, 'showCountries']);
Route::get('/countries/{cca3}', [CountryController::class, 'showCountriesByCca3']);
