<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'bed_room', 'bed_id', 'room_id');
    }
}
