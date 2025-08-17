<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\JsonResponse;

class CountryController extends Controller
{
    public function showCountries(): JsonResponse
    {
        $countries = Country::all();
        return response()->json($countries);
    }

    public function showCountriesByCca3(string $cca3): JsonResponse
    {
        $country = Country::where('cca3', $cca3)->firstOrFail();
        return response()->json($country);
    }
}
