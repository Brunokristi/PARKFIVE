<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HotelPropertyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_property_content_id',
        'src',
        'sort_order',
    ];

    public function content(): BelongsTo
    {
        return $this->belongsTo(HotelPropertyContent::class, 'hotel_property_content_id');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(HotelPropertyImageTranslation::class);
    }
}