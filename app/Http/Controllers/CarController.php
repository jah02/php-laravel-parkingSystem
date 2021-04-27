<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarTime;
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
                'required'
            ]
        ]);

        $car = new Car();
        $car->vehicle_type = $request->vehicleType;
        $car->license_plate = strtoupper($request->licensePlate);
        $car->user_id = auth()->user()->id;
        $car->save();

        $carTime = new CarTime();
        //$carTime->arrival_time = DateTime::createFromFormat('Y-m-d H:i:s', $validatedData['arrivalTime']);
        $carTime->car_id = $car->id;
        $carTime->arrival_time = $request->arrivalTime;
        $carTime->save();

        return redirect()->route('index');
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
