<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index()
    {
        $parkedVehicles = DB::table('cars')
            ->join('cars_time', function ($join) {
                $join->on('cars.id', '=', 'cars_time.id')
                    ->where('cars_time.departure_time', '=', null);
            })
            ->get();

        return view('main.index', [
            'parkedVehicles' => $parkedVehicles,
        ]);
    }
}
