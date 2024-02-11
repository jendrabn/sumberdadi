<?php

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Storage::exists('seeds/cities.json')) {
            $cities = collect(json_decode(Storage::get('seeds/cities.json'), true));

            City::insert($cities->map(function ($city) {
                return [
                    'id' => $city['city_id'],
                    'province_id' => $city['province_id'],
                    'name' => $city['city_name'],
                    'type' => $city['type'],
                    'postal_code' => $city['postal_code']
                ];
            })->toArray());
        }
    }
}
