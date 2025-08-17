<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CountryService
{
    public function updateFromApi(): array
    {
        try {
            $response = Http::get('https://restcountries.com/v3.1/all?fields=name,flags,capital,region,population,cca3,subregion,area');
            $countries = $response->json();

            $created = 0;
            $updated = 0;

            foreach ($countries as $countryData) {
                $data = [
                    'cca3' => $countryData['cca3'] ?? null,
                    'name_common' => $countryData['name']['common'] ?? '',
                    'name_official' => $countryData['name']['official'] ?? '',
                    'native_name' => isset($countryData['nativeName']['ara']['official']) ? $countryData['nativeName']['ara']['official'] : null,
                    'region' => $countryData['region'] ?? null,
                    'subregion' => $countryData['subregion'] ?? null,
                    'capital' => isset($countryData['capital']) ? implode(', ', $countryData['capital']) : null,
                    'population' => $countryData['population'] ?? 0,
                    'area' => $countryData['area'] ?? 0,
                    'flag_emoji' => $countryData['flags']['png'] ?? null,
                ];

                if ($data['cca3']) {
                    $country = Country::updateOrCreate(
                        ['cca3' => $data['cca3']],
                        $data
                    );
                    if ($country->wasRecentlyCreated) {
                        $created++;
                    } else {
                        $updated++;
                    }
                }
            }

            return ['created' => $created, 'updated' => $updated];
        } catch (\Exception $e) {
            Log::error('Error updating countries from API: ' . $e->getMessage());
            return ['created' => 0, 'updated' => 0];
        }
    }
}
