<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelPropertySectionRowTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_property_section_row_id',
        'locale_code',
        'label',
    ];

    public function row(): BelongsTo
    {
        return $this->belongsTo(HotelPropertySectionRow::class, 'hotel_property_section_row_id');
    }
}