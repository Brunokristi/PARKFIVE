<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HotelPropertySectionRow extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_property_section_id',
        'slug',
        'row_type',
        'sort_order',
        'count_value',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(HotelPropertySection::class, 'hotel_property_section_id');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(HotelPropertySectionRowTranslation::class);
    }
}