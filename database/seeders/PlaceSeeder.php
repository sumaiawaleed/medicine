<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\City;
use App\Models\Location;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $city  = City::create([
            'name' => '{"en": "Sana\'a","ar": "صنعاء"}',
        ]);

        $area = Area::create([
            'city_id' => $city->id,
            'name' => '{"en": "Hada","ar": "حدة"}',

        ]);

        Location::create([
            'city_id' => $city->id,
            'area_id' => $area->id,
            'lat' => 24.468739,
            'log' => 54.369466,
            'address' => '{"en": "Hada","ar": "جولة المصباحي"}' ,
        ]);
        $area = Area::create([
            'city_id' => $city->id,
            'name' => '{"en": "","ar": "حدة"}',

        ]);
    }
}
