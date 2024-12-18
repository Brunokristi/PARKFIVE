<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_per_night',
        'ammount',
        'color',
        'guests',
    ];

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_room', 'room_id', 'feature_id');
    }

    public function beds()
    {
        return $this->belongsToMany(Bed::class, 'bed_room', 'room_id', 'bed_id');
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_room')
                    ->withTimestamps();
    }
}
