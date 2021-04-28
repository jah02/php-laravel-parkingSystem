<?php

namespace Database\Seeders;

use App\Models\Car;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class CarTimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carIdList = Car::select('id')->get();
        $dateStart = 1614589200;
        $dateEnd = 1619773200;
        $currentDate = new DateTime();

        for($i=0; $i<count($carIdList); $i++) {
            //Rand arrival time
            $arrivalTimestamp = rand($dateStart, $dateEnd);
            $arrivalDate = new DateTime();
            $arrivalDate->setTimestamp($arrivalTimestamp);

            //Rand departure time
            $departureDate = null;
            if(rand(0, 1)) {
                $departureDate = new DateTime();
                $departureDate->setTimestamp(rand($arrivalTimestamp, $dateEnd));
            }

            //Calculate cost
            $cost = null;
            if($departureDate) {
                $vehicle = Car::find($carIdList[$i]->id);
                $cost = $this->calculateCost($arrivalDate, $departureDate, $vehicle->vehicle_type);
            }

            DB::table('cars_time')->insert([
                'car_id' => $carIdList[$i]->id,
                'arrival_time' => $arrivalDate->format('Y-m-d H:i:s'),
                'departure_time' => $departureDate,
                'cost' => $cost,
                'created_at' => $currentDate->format('Y-m-d H:i:s'),
                'updated_at' => $currentDate->format('Y-m-d H:i:s'),
            ]);
        }
    }

    private function calculateCost(DateTime $arrivalTime, DateTime $departureTime, string $vehicleType): float
    {
        $types = [
            'CAR' => 1.0,
            'BUS' => 1.1,
            'TRUCK' => 1.5,
            'MOTORCYCLE' => 0.7,
        ];
        $pricePerHour = 2.0;

        $diff = $departureTime->diff($arrivalTime);
        $hours = $diff->h + ($diff->days*24);

        return round($hours*$pricePerHour*$types[$vehicleType], 2);
    }
}
