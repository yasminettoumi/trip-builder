<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Airport;

class AirportController extends Controller
{
    /**
     * GET /api/airports
     */
    public function index()
    {
        return response()->json(
            Airport::orderBy('city')->get()
        );
    }
}
