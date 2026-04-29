<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HotelFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'code',
        'sort_order',
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(HotelFeatureTranslation::class);
    }

    public function roomTypes(): BelongsToMany
    {
        return $this->belongsToMany(HotelRoomType::class, 'hotel_room_type_feature');
    }
}