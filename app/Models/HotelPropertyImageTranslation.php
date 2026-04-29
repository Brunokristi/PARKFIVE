<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelPropertyImageTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_property_image_id',
        'locale_code',
        'alt',
    ];

    public function image(): BelongsTo
    {
        return $this->belongsTo(HotelPropertyImage::class, 'hotel_property_image_id');
    }
}