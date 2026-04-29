<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelPropertySectionTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_property_section_id',
        'locale_code',
        'heading',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(HotelPropertySection::class, 'hotel_property_section_id');
    }
}