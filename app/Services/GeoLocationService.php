<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeoLocationService
{
    /**
     * Validate if a city + country exists using OpenStreetMap Nominatim
     */
    public function locationExists(string $city, string $country): bool
    {
        $query = trim($city . ', ' . $country);

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'EventHub Laravel App (Educational Project)'
            ])->timeout(5)->get(
                'https://nominatim.openstreetmap.org/search',
                [
                    'q' => $query,
                    'format' => 'json',
                    'limit' => 1,
                ]
            );

            if (!$response->successful()) {
                return false;
            }

            $data = $response->json();
            return is_array($data) && count($data) > 0;

        } catch (\Exception $e) {
            // Fail safely (do not crash app)
            return false;
        }
    }
}
