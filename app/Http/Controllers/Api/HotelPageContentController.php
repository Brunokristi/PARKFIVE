<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\HotelContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HotelPageContentController extends Controller
{
    public function __construct(private readonly HotelContentService $contentService)
    {
    }

    public function show(Request $request, string $page): JsonResponse
    {
        $locale = $request->query('locale', app()->getLocale());

        $hotel = $this->contentService->resolveHotel($request->getHost());

        if (! $hotel) {
            return response()->json(['message' => 'Hotel not found'], 404);
        }

        $pageContent = $hotel->pageContents()
            ->where('page_key', $page)
            ->where('locale_code', $locale)
            ->first();

        if (! $pageContent) {
            $pageContent = $hotel->pageContents()
                ->where('page_key', $page)
                ->where('locale_code', 'sk')
                ->first();
        }

        if (! $pageContent) {
            return response()->json(['message' => 'Page content not found'], 404);
        }

        return response()->json([
            'hotel' => [
                'id' => $hotel->id,
                'slug' => $hotel->slug,
                'name' => $hotel->name,
            ],
            'content' => $pageContent->content_json,
        ]);
    }
}