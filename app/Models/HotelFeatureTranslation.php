<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelFeatureTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_feature_id',
        'locale_code',
        'label',
    ];

    public function feature(): BelongsTo
    {
        return $this->belongsTo(HotelFeature::class, 'hotel_feature_id');
    }
}