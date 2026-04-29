<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HotelRoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'slug',
        'sort_order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(HotelRoomTypeTranslation::class);
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(HotelFeature::class, 'hotel_room_type_feature');
    }
}