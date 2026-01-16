<?php

namespace Database\Seeders;

use App\Models\Airline;
use App\Models\Airport;
use App\Models\Flight;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airline = Airline::where('code', 'AC')->first();
        $yul = Airport::where('code', 'YUL')->first();
        $yvr = Airport::where('code', 'YVR')->first();

        Flight::create([
            'airline_id' => $airline->id,
            'number' => '301',
            'departure_airport_id' => $yul->id,
            'arrival_airport_id' => $yvr->id,
            'departure_time' => '07:35',
            'arrival_time' => '10:05',
            'price' => 273.23,
        ]);

        Flight::create([
            'airline_id' => $airline->id,
            'number' => '302',
            'departure_airport_id' => $yvr->id,
            'arrival_airport_id' => $yul->id,
            'departure_time' => '11:30',
            'arrival_time' => '19:11',
            'price' => 220.63,
        ]);
    }
}
