<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\HotelContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HotelPropertyController extends Controller
{
    public function __construct(private readonly HotelContentService $contentService)
    {
    }

    public function show(Request $request): JsonResponse
    {
        $locale = $request->query('locale', app()->getLocale());

        $hotel = $this->contentService->resolveHotel($request->getHost());

        if (! $hotel) {
            return response()->json(['message' => 'Hotel not found'], 404);
        }

        $propertyContent = $hotel->propertyContent()
            ->with([
                'translations',
                'images.translations',
                'sections.translations',
                'sections.rows.translations',
            ])
            ->first();

        if (! $propertyContent) {
            return response()->json(['message' => 'Property content not found'], 404);
        }

        $contentTranslations = $propertyContent->translations;
        $images = $propertyContent->images->sortBy('sort_order')->values();
        $sections = $propertyContent->sections->sortBy('sort_order')->values();
        $roomTypes = $hotel->roomTypes()
            ->where('active', true)
            ->with(['translations', 'features.translations'])
            ->orderBy('sort_order')
            ->get();
        $features = $hotel->features()
            ->with('translations')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'hotel' => [
                'id' => $hotel->id,
                'slug' => $hotel->slug,
                'name' => $hotel->name,
            ],
            'subtitle' => $this->contentService->localizedObject($contentTranslations, 'subtitle'),
            'description' => $this->contentService->localizedObject($contentTranslations, 'description'),
            'compareHeading' => $this->contentService->localizedObject($contentTranslations, 'compare_heading'),
            'compareDescription' => $this->contentService->localizedObject($contentTranslations, 'compare_description'),
            'images' => $images->map(function ($image) {
                return [
                    'src' => $this->contentService->versionedAssetUrl($image->src),
                    'alt' => $this->contentService->localizedObject($image->translations, 'alt'),
                ];
            })->values(),
            'sections' => $sections->map(function ($section) {
                return [
                    'id' => $section->slug,
                    'heading' => $this->contentService->localizedObject($section->translations, 'heading'),
                    'rows' => $section->rows
                        ->sortBy('sort_order')
                        ->map(function ($row) {
                            return [
                                'id' => $row->slug,
                                'label' => $this->contentService->localizedObject($row->translations, 'label'),
                                'count' => $row->row_type === 'count' ? (int) $row->count_value : null,
                                'checked' => $row->row_type === 'check' ? true : null,
                            ];
                        })
                        ->values(),
                ];
            })->values(),
            'roomFeatures' => $features->map(function ($feature) use ($locale) {
                return $this->contentService->localizedValue($feature->translations, 'label', $locale);
            })->values(),
            'roomTypes' => $roomTypes->map(function ($roomType) use ($locale) {
                return [
                    'id' => $roomType->slug,
                    'slug' => $roomType->slug,
                    'title' => $this->contentService->localizedObject($roomType->translations, 'title'),
                    'features' => $roomType->features
                        ->map(function ($feature) use ($locale) {
                            return $this->contentService->localizedValue($feature->translations, 'label', $locale);
                        })
                        ->values(),
                ];
            })->values(),
        ]);
    }
}