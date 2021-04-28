<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarTime;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CarController extends Controller
{
    public function getAdd()
    {
        return view('cars.add', [
            'availableTypes' => $this->getVehiclesTypes(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
        $request->validate([
            'vehicleType' => [
                'required',
                'max:255',
                Rule::in($this->getVehiclesTypes()),
            ],
            'licensePlate' => [
                'required',
                'max:255'
            ],
            'arrivalTime' => [
                'required',
                'after_or_equal:now'
            ]
        ]);

        $car = new Car();
        $car->vehicle_type = $request->vehicleType;
        $car->license_plate = strtoupper($request->licensePlate);
        $car->user_id = auth()->user()->id;
        $car->save();

        $carTime = new CarTime();
        $carTime->car_id = $car->id;
        $carTime->arrival_time = $request->arrivalTime;
        $carTime->save();

        return redirect()->route('index');
    }

    public function getDetails(int $id)
    {
        $car = Car::find($id);
        if(!$car) {
            abort(404);
        }

        $carTime = CarTime::where('car_id', '=', $car->id)->firstOrFail();
        $user = User::find($car->user_id);

        return view('cars.details', [
            'car' => $car,
            'carTime' => $carTime,
            'author' => $user,
        ]);
    }

    public function getUpdate(int $id)
    {
        $car = Car::find($id);
        if(!$car) {
            abort(404);
        }

        $carTime = CarTime::where('car_id', '=', $car->id)->firstOrFail();
        if($carTime->departure_time) {
            abort(404);
        }

        return view('cars.update', [
            'car' => $car,
            'carTime' => $carTime,
            'availableTypes' => $this->getVehiclesTypes(),
        ]);
    }

    public function update(int $id, Request $request)
    {
        $request->validate([
            'departureTime' => [
                'required',
                'after_or_equal:now'
            ],
            'vehicleType' => [
                'required',
                'max:255',
                Rule::in($this->getVehiclesTypes()),
            ],
            'licensePlate' => [
                'required',
                'max:255'
            ],
        ]);

        $carTime = CarTime::where('car_id', '=', $id)->first();
        if(!$carTime || $carTime->departure_time) {
            abort(404);
        }

        $car = Car::find($id);
        $car->vehicle_type = $request->vehicleType;
        $car->license_plate = $request->licensePlate;
        $car->save();

        $carTime->departure_time = str_replace('T', ' ', $request->departureTime);
        $carTime->cost = $this->calculateCost(
            DateTime::createFromFormat('Y-m-d H:i:s', $carTime->arrival_time),
            DateTime::createFromFormat('Y-m-d H:i', $carTime->departure_time),
            $car->vehicle_type
        );
        $carTime->save();

        return redirect()->route('details', ['id' => $id]);
    }

    private function getVehiclesTypes(): array
    {
        return [
            'CAR',
            'BUS',
            'TRUCK',
            'MOTORCYCLE',
        ];
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
