<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelPropertyContentTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_property_content_id',
        'locale_code',
        'subtitle',
        'description',
        'compare_heading',
        'compare_description',
    ];

    public function content(): BelongsTo
    {
        return $this->belongsTo(HotelPropertyContent::class, 'hotel_property_content_id');
    }
}