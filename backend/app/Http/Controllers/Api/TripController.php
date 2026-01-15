<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TripBuilderService;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function __construct(
        private TripBuilderService $tripBuilderService
    ) {}

    public function search(Request $request)
    {
        $data = $request->validate([
            'from' => 'required|string|size:3',
            'to' => 'required|string|size:3',
            'departure_date' => 'required|date',
            'type' => 'required|in:one_way,round_trip',
        ]);

        $trip = $this->tripBuilderService->build($data);

        return response()->json($trip);
    }

    /**
     * GET /api/trips/{id}
     */
    public function show(int $id)
    {
        $trip = Trip::with([
            'flights.airline',
            'flights.departureAirport',
            'flights.arrivalAirport'
        ])->findOrFail($id);

        return response()->json($trip);
    }

}
