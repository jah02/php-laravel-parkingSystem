<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index()
    {
        $parkedVehicles = DB::table('cars')
            ->join('cars_time', function ($join) {
                $join->on('cars.id', '=', 'cars_time.car_id')
                    ->where('cars_time.departure_time', '=', null);
            })
            ->orderByDesc('arrival_time')
            ->paginate(50)->items();

        return view('main.index', [
            'parkedVehicles' => $parkedVehicles,
        ]);
    }

    public function getHistoryData(): JsonResponse
    {
        $vehiclesHistory = DB::table('cars')
            ->join('cars_time', function ($join) {
                $join->on('cars.id', '=', 'cars_time.car_id')
                    ->where('cars_time.departure_time', '!=', null);
            })
            ->orderByDesc('departure_time')
            ->paginate(100)->items();

        return new JsonResponse(['vehiclesHistory' => $vehiclesHistory]);
    }

    public function getMainData(): JsonResponse
    {
        $parkedVehicles = DB::table('cars')
            ->join('cars_time', function ($join) {
                $join->on('cars.id', '=', 'cars_time.car_id')
                    ->where('cars_time.departure_time', '=', null);
            })
            ->orderByDesc('arrival_time')
            ->paginate(50)->items();

        return new JsonResponse(['vehiclesMain' => $parkedVehicles]);
    }

    public function getSearchMainData(Request $request): JsonResponse
    {
        $searchText = $request->searchText;

        $parkedVehicles = DB::table('cars')
            ->join('cars_time', function ($join) {
                $join->on('cars.id', '=', 'cars_time.car_id')
                    ->where('cars_time.departure_time', '=', null);
            })
            ->where('license_plate', 'like', "%$searchText%")
            ->orWhere('arrival_time', 'like', "%$searchText%")
            ->orderByDesc('arrival_time')
            ->paginate(50)->items();

        return new JsonResponse(['vehiclesMain' => $parkedVehicles]);
    }

    public function getSearchHistoryData(Request $request): JsonResponse
    {
        $searchText = $request->searchText;

        $vehiclesHistory = DB::table('cars')
            ->join('cars_time', function ($join) {
                $join->on('cars.id', '=', 'cars_time.car_id')
                    ->where('cars_time.departure_time', '!=', null);
            })
            ->where('license_plate', 'like', "%$searchText%")
            ->orWhere('departure_time', 'like', "%$searchText%")
            ->orWhere('arrival_time', 'like', "%$searchText%")
            ->orderByDesc('departure_time')
            ->paginate(50)->items();

        return new JsonResponse(['vehiclesHistory' => $vehiclesHistory]);
    }
}
