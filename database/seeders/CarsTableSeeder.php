<?php

namespace Database\Seeders;

use App\Models\User;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = new DateTime();
        $userId = User::select('id')->get();

        for($i=0; $i<1000; $i++) {
            DB::table('cars')->insert([
                'vehicle_type' => $this->getRandomVehicleType(),
                'license_plate' => $this->getRandomLicensePlate(),
                'user_id' => $userId[0]->id,
                'created_at' => $date->format('Y-m-d H:i:s'),
                'updated_at' => $date->format('Y-m-d H:i:s'),
            ]);
        }
    }

    private function getRandomVehicleType(): string
    {
        $types = [
            'CAR',
            'BUS',
            'TRUCK',
            'MOTORCYCLE',
        ];

        return $types[rand(0, count($types)-1)];
    }

    private function getRandomLicensePlate(): string
    {
        $prefix = ['BI', 'BBI', 'CB', 'CT', 'CWL', 'DW', 'EL', 'ELW', 'FZ', 'GD'];
        $charactersArray = str_split('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $suffix = "";
        for($i=0; $i<4; $i++) {
            $suffix .= $charactersArray[rand(0, count($charactersArray)-1)];
        }

        return $prefix[rand(0, count($prefix)-1)].$suffix;
    }
}
