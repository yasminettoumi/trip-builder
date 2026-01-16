<?php

namespace App\Services;

use App\Models\Airport;
use App\Models\Flight;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class TripBuilderService
{
    public function build(array $data): array
    {
        $departureDate = Carbon::parse($data['departure_date']);

        // Validation dates
        if ($departureDate->isBefore(now()->startOfDay())) {
            throw ValidationException::withMessages([
                'departure_date' => 'Departure date must be in the future.',
            ]);
        }

        if ($departureDate->greaterThan(now()->addDays(365))) {
            throw ValidationException::withMessages([
                'departure_date' => 'Departure date must be within 365 days.',
            ]);
        }

        $fromAirport = Airport::where('code', $data['from'])->firstOrFail();
        $toAirport = Airport::where('code', $data['to'])->firstOrFail();

        // Vol aller
        $outboundFlight = Flight::where('departure_airport_id', $fromAirport->id)
            ->where('arrival_airport_id', $toAirport->id)
            ->firstOrFail();

        $flights = [
            [
                'flight' => $outboundFlight,
                'date' => $departureDate->toDateString(),
            ]
        ];

        $totalPrice = $outboundFlight->price;

        // Aller-retour
        if ($data['type'] === 'round_trip') {
            if (empty($data['return_date'])) {
                throw ValidationException::withMessages([
                    'return_date' => 'Return date is required for round trip.',
                ]);
            }

            $returnDate = Carbon::parse($data['return_date']);

            if ($returnDate->isBefore(now()->startOfDay())) {
                throw ValidationException::withMessages([
                    'return_date' => 'Return date must be in the future.',
                ]);
            }

            if ($returnDate->greaterThan(now()->addDays(365))) {
                throw ValidationException::withMessages([
                    'return_date' => 'Return date must be within 365 days.',
                ]);
            }

            $returnFlight = Flight::where('departure_airport_id', $toAirport->id)
                ->where('arrival_airport_id', $fromAirport->id)
                ->firstOrFail();

            $flights[] = [
                'flight' => $returnFlight,
                'date' => $returnDate->toDateString(),
            ];

            $totalPrice += $returnFlight->price;
        }

        $trip = Trip::create([
            'type' => $data['type'],
            'total_price' => $totalPrice,
        ]);

        foreach ($flights as $item) {
            $trip->flights()->attach(
                $item['flight']->id,
                ['departure_date' => $item['date']]
            );
        }

        return [
            'trip_id' => $trip->id,
            'type' => $trip->type,
            'total_price' => $trip->total_price,
            'flights' => $trip->flights()->with([
                'airline',
                'departureAirport',
                'arrivalAirport'
            ])->get(),
        ];
    }
}
