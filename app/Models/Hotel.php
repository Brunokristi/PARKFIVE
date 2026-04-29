<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'status',
    ];

    public function domains(): HasMany
    {
        return $this->hasMany(HotelDomain::class);
    }

    public function pageContents(): HasMany
    {
        return $this->hasMany(HotelPageContent::class);
    }

    public function propertyContent(): HasOne
    {
        return $this->hasOne(HotelPropertyContent::class);
    }

    public function roomTypes(): HasMany
    {
        return $this->hasMany(HotelRoomType::class);
    }

    public function features(): HasMany
    {
        return $this->hasMany(HotelFeature::class);
    }
}