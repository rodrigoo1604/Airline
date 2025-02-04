<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'departure', 'arrival', 'plane_id', 'status'];

    public function plane()
    {
        return $this->belongsTo(Plane::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

