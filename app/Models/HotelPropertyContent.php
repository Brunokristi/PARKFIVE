<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HotelPropertyContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(HotelPropertyContentTranslation::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(HotelPropertyImage::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(HotelPropertySection::class);
    }
}