<?php

namespace App\Services\Admin;

use App\Models\Hotel;
use App\Models\HotelFeature;
use App\Models\HotelPageContent;
use App\Models\HotelPropertyContent;
use App\Models\HotelPropertyImage;
use App\Models\HotelPropertySection;
use App\Models\HotelPropertySectionRow;
use App\Models\HotelRoomType;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

class HotelEditorService
{
    public function getPrimaryHotel(): Hotel
    {
        $hotel = Hotel::query()->with(['domains', 'pageContents', 'propertyContent.translations', 'propertyContent.images.translations', 'propertyContent.sections.translations', 'propertyContent.sections.rows.translations', 'roomTypes.translations', 'roomTypes.features.translations', 'features.translations'])->first();

        if ($hotel) {
            return $hotel;
        }

        return Hotel::query()->create([
            'slug' => 'parkfive',
            'name' => 'parkFIVE',
            'status' => 'active',
        ]);
    }

    public function exportHotelSettings(Hotel $hotel): array
    {
        return [
            'name' => $hotel->name,
            'slug' => $hotel->slug,
            'status' => $hotel->status,
            'domains' => $hotel->domains()->orderBy('is_primary', 'desc')->orderBy('domain')->pluck('domain')->all(),
        ];
    }

    public function saveHotelSettings(Hotel $hotel, array $data): void
    {
        DB::transaction(function () use ($hotel, $data): void {
            $hotel->update([
                'name' => $data['name'],
                'slug' => $data['slug'],
                'status' => $data['status'],
            ]);

            $domains = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $data['domains']))));

            $hotel->domains()->delete();

            foreach ($domains as $index => $domain) {
                if ($domain === '') {
                    continue;
                }

                $hotel->domains()->create([
                    'domain' => $domain,
                    'is_primary' => $index === 0,
                ]);
            }
        });
    }

    public function exportPageContents(Hotel $hotel): array
    {
        $pages = [];

        foreach ($hotel->pageContents()->orderBy('page_key')->orderBy('locale_code')->get() as $pageContent) {
            $pages[$pageContent->page_key][$pageContent->locale_code] = $pageContent->content_json;
        }

        return $pages;
    }

    public function savePageContentsFromJson(Hotel $hotel, string $json): void
    {
        $payload = $this->decodeJson($json);

        DB::transaction(function () use ($hotel, $payload): void {
            $hotel->pageContents()->delete();

            foreach ($payload as $pageKey => $locales) {
                foreach ($locales as $localeCode => $contentJson) {
                    $hotel->pageContents()->create([
                        'page_key' => (string) $pageKey,
                        'locale_code' => (string) $localeCode,
                        'content_json' => $contentJson,
                    ]);
                }
            }
        });
    }

    public function exportPropertyContent(Hotel $hotel): array
    {
        $propertyContent = $hotel->propertyContent;

        if (! $propertyContent) {
            return $this->defaultPropertyTemplate();
        }

        $translations = [];
        foreach ($propertyContent->translations as $translation) {
            $translations[$translation->locale_code] = [
                'subtitle' => $translation->subtitle,
                'description' => $translation->description,
                'compare_heading' => $translation->compare_heading,
                'compare_description' => $translation->compare_description,
            ];
        }

        $images = $propertyContent->images->sortBy('sort_order')->values()->map(function (HotelPropertyImage $image): array {
            $alts = [];

            foreach ($image->translations as $translation) {
                $alts[$translation->locale_code] = $translation->alt;
            }

            return [
                'src' => $image->src,
                'alt' => $alts,
            ];
        })->all();

        $sections = $propertyContent->sections->sortBy('sort_order')->values()->map(function (HotelPropertySection $section): array {
            $sectionTitles = [];
            foreach ($section->translations as $translation) {
                $sectionTitles[$translation->locale_code] = $translation->heading;
            }

            return [
                'slug' => $section->slug,
                'heading' => $sectionTitles,
                'rows' => $section->rows->sortBy('sort_order')->values()->map(function (HotelPropertySectionRow $row): array {
                    $labels = [];
                    foreach ($row->translations as $translation) {
                        $labels[$translation->locale_code] = $translation->label;
                    }

                    return [
                        'slug' => $row->slug,
                        'type' => $row->row_type,
                        'count' => $row->count_value,
                        'label' => $labels,
                    ];
                })->all(),
            ];
        })->all();

        $features = $hotel->features->sortBy('sort_order')->values()->map(function (HotelFeature $feature): array {
            $labels = [];
            foreach ($feature->translations as $translation) {
                $labels[$translation->locale_code] = $translation->label;
            }

            return [
                'code' => $feature->code,
                'label' => $labels,
            ];
        })->all();

        $roomTypes = $hotel->roomTypes->sortBy('sort_order')->values()->map(function (HotelRoomType $roomType): array {
            $titles = [];
            foreach ($roomType->translations as $translation) {
                $titles[$translation->locale_code] = $translation->title;
            }

            return [
                'slug' => $roomType->slug,
                'title' => $titles,
                'feature_codes' => $roomType->features->pluck('code')->values()->all(),
            ];
        })->all();

        return [
            'translations' => $translations,
            'images' => $images,
            'sections' => $sections,
            'features' => $features,
            'roomTypes' => $roomTypes,
        ];
    }

    public function savePropertyContentFromJson(Hotel $hotel, string $json): void
    {
        $payload = $this->decodeJson($json);

        DB::transaction(function () use ($hotel, $payload): void {
            $hotel->propertyContent()->delete();

            $propertyContent = $hotel->propertyContent()->create([]);

            foreach (($payload['translations'] ?? []) as $localeCode => $translation) {
                $propertyContent->translations()->create([
                    'locale_code' => $localeCode,
                    'subtitle' => $translation['subtitle'] ?? '',
                    'description' => $translation['description'] ?? '',
                    'compare_heading' => $translation['compare_heading'] ?? '',
                    'compare_description' => $translation['compare_description'] ?? '',
                ]);
            }

            foreach (($payload['images'] ?? []) as $index => $image) {
                $imageModel = $propertyContent->images()->create([
                    'src' => $image['src'] ?? '',
                    'sort_order' => $index,
                ]);

                foreach (($image['alt'] ?? []) as $localeCode => $alt) {
                    $imageModel->translations()->create([
                        'locale_code' => $localeCode,
                        'alt' => $alt,
                    ]);
                }
            }

            foreach (($payload['sections'] ?? []) as $sectionIndex => $section) {
                $sectionModel = $propertyContent->sections()->create([
                    'slug' => $section['slug'] ?? 'section-'.$sectionIndex,
                    'sort_order' => $sectionIndex,
                ]);

                foreach (($section['heading'] ?? []) as $localeCode => $heading) {
                    $sectionModel->translations()->create([
                        'locale_code' => $localeCode,
                        'heading' => $heading,
                    ]);
                }

                foreach (($section['rows'] ?? []) as $rowIndex => $row) {
                    $rowModel = $sectionModel->rows()->create([
                        'slug' => $row['slug'] ?? 'row-'.$rowIndex,
                        'row_type' => $row['type'] ?? 'check',
                        'count_value' => $row['count'] ?? null,
                        'sort_order' => $rowIndex,
                    ]);

                    foreach (($row['label'] ?? []) as $localeCode => $label) {
                        $rowModel->translations()->create([
                            'locale_code' => $localeCode,
                            'label' => $label,
                        ]);
                    }
                }
            }

            $featureIds = [];
            foreach (($payload['features'] ?? []) as $featureIndex => $feature) {
                $featureModel = $hotel->features()->create([
                    'code' => $feature['code'] ?? 'feature-'.$featureIndex,
                    'sort_order' => $featureIndex,
                ]);

                foreach (($feature['label'] ?? []) as $localeCode => $label) {
                    $featureModel->translations()->create([
                        'locale_code' => $localeCode,
                        'label' => $label,
                    ]);
                }

                $featureIds[$featureModel->code] = $featureModel->id;
            }

            foreach (($payload['roomTypes'] ?? []) as $roomTypeIndex => $roomType) {
                $roomTypeModel = $hotel->roomTypes()->create([
                    'slug' => $roomType['slug'] ?? 'room-'.$roomTypeIndex,
                    'sort_order' => $roomTypeIndex,
                    'active' => true,
                ]);

                foreach (($roomType['title'] ?? []) as $localeCode => $title) {
                    $roomTypeModel->translations()->create([
                        'locale_code' => $localeCode,
                        'title' => $title,
                    ]);
                }

                $attachIds = [];
                foreach (($roomType['feature_codes'] ?? []) as $featureCode) {
                    if (isset($featureIds[$featureCode])) {
                        $attachIds[] = $featureIds[$featureCode];
                    }
                }

                if ($attachIds !== []) {
                    $roomTypeModel->features()->sync($attachIds);
                }
            }
        });
    }

    public function encodeJson(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{}';
    }

    private function decodeJson(string $json): array
    {
        try {
            $decoded = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $exception) {
            throw new RuntimeException('Invalid JSON payload: '.$exception->getMessage(), 0, $exception);
        }

        return is_array($decoded) ? $decoded : [];
    }

    private function defaultPropertyTemplate(): array
    {
        return [
            'translations' => [
                'en' => [
                    'subtitle' => 'Hotel',
                    'description' => '',
                    'compare_heading' => 'Comparison',
                    'compare_description' => '',
                ],
                'sk' => [
                    'subtitle' => 'Hotel',
                    'description' => '',
                    'compare_heading' => 'Porovnanie',
                    'compare_description' => '',
                ],
            ],
            'images' => [],
            'sections' => [],
            'features' => [],
            'roomTypes' => [],
        ];
    }
}