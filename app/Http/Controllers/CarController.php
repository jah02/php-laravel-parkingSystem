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
    public function index()
    {
        return view('cars.add', [
            'availableTypes' => $this->getVehiclesTypes(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCar(Request $request)
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

    private function getVehiclesTypes(): array
    {
        return [
            'CAR',
            'BUS',
            'TRUCK',
            'MOTORCYCLE',
        ];
    }
}
