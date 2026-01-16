<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'total_price'];

    public function flights()
    {
        return $this->belongsToMany(Flight::class, 'trip_flights')
                    ->withPivot('departure_date')
                    ->withTimestamps();
    }
}
