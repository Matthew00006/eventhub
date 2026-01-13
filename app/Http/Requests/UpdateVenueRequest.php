<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\GeoLocationService;

class UpdateVenueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:120',
            'city' => 'required|string|max:80',
            'country' => 'required|string|max:80',
            'address' => 'nullable|string|max:200',
            'description' => 'nullable|string|max:2000',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $geoService = app(GeoLocationService::class);

            if (!$geoService->locationExists(
                $this->city,
                $this->country
            )) {
                $validator->errors()->add(
                    'city',
                    'The city and country could not be validated using an external map service.'
                );
            }
        });
    }
}
