<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flight;

class FlightController extends Controller
{
    /**
     * GET /api/flights
     */
    public function index()
    {
        return response()->json(
            Flight::with([
                'airline',
                'departureAirport',
                'arrivalAirport'
            ])->get()
        );
    }
}
