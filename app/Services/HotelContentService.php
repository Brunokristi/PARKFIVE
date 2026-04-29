<?php

namespace App\Services;

use App\Models\Hotel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;

class HotelContentService
{
    public function resolveHotel(?string $host = null): ?Hotel
    {
        $query = Hotel::query()
            ->with('domains')
            ->whereHas('domains', function ($domains) use ($host) {
                $domains->where('domain', $host);
            });

        $hotel = $query->first();

        return $hotel ?: Hotel::query()->orderBy('id')->first();
    }

    public function localizedObject(Collection $translations, string $field): array
    {
        $localized = [];

        foreach ($translations as $translation) {
            $localized[$translation->locale_code] = $translation->{$field};
        }

        return $localized;
    }

    public function localizedValue(Collection $translations, string $field, string $locale): string
    {
        foreach ($translations as $translation) {
            if ($translation->locale_code === $locale) {
                return $translation->{$field};
            }
        }

        foreach ($translations as $translation) {
            if ($translation->locale_code === 'sk') {
                return $translation->{$field};
            }
        }

        $first = $translations->first();

        return $first?->{$field} ?? '';
    }

    public function versionedAssetUrl(string $path): string
    {
        if ($path === '' || ! str_starts_with($path, '/assets/')) {
            return $path;
        }

        $publicPath = public_path(ltrim($path, '/'));

        if (! File::exists($publicPath)) {
            return $path;
        }

        $version = (string) File::lastModified($publicPath);

        return $path.(str_contains($path, '?') ? '&' : '?').'v='.$version;
    }
}