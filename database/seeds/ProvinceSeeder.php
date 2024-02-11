<?php

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Storage::exists('seeds/provinces.json')) {
            $provinces = collect(json_decode(Storage::get('seeds/provinces.json'), true));

            Province::insert($provinces->map(function ($province) {
                return ['id' => $province['province_id'], 'name' => $province['province']];
            })->toArray());
        }
    }
}
