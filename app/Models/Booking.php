<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'check_in_date',
        'check_out_date',
        'total_price',
        'status',
    ];


    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_room')
                    ->withTimestamps();
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
