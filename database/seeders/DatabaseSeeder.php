<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $hotel = Hotel::firstOrCreate(
            ['slug' => 'parkfive'],
            ['name' => 'parkFIVE', 'status' => 'active']
        );

        $domains = [
            ['domain' => 'localhost', 'is_primary' => true],
            ['domain' => '127.0.0.1', 'is_primary' => false],
        ];

        foreach ($domains as $d) {
            $hotel->domains()->firstOrCreate(['domain' => $d['domain']], ['is_primary' => $d['is_primary']]);
        }

        $pageContents = [
            'home' => [
                'sk' => [
                    'heading' => 'parkFIVE',
                    'description' => 'Vyberte si izbu, služby alebo si naplánujte výlet v okolí.',
                    'images' => [
                        ['src' => '/assets/image.jpg', 'alt' => 'Hotelová izba'],
                        ['src' => '/assets/image2.jpg', 'alt' => 'Okolie hotela'],
                    ],
                    'roomTypes' => [
                        ['id' => 'standard', 'slug' => 'standard', 'title' => 'Štandard', 'features' => ['Wi-Fi', 'TV', 'Kúpeľňa']],
                        ['id' => 'premium', 'slug' => 'premium', 'title' => 'Premium', 'features' => ['Wi-Fi', 'Balkón', 'Výhľad']],
                    ],
                    'infos' => [
                        ['id' => 'parking', 'heading' => 'Parkovanie', 'text' => 'Parkovanie je dostupné priamo pri objekte.', 'opened' => true],
                        ['id' => 'breakfast', 'heading' => 'Raňajky', 'text' => 'Raňajky sú dostupné každý deň od 7:00.'],
                    ],
                ],
                'en' => [
                    'heading' => 'parkFIVE',
                    'description' => 'Choose a room, services, or plan a trip nearby.',
                    'images' => [
                        ['src' => '/assets/image.jpg', 'alt' => 'Hotel room'],
                        ['src' => '/assets/image2.jpg', 'alt' => 'Hotel surroundings'],
                    ],
                    'roomTypes' => [
                        ['id' => 'standard', 'slug' => 'standard', 'title' => 'Standard', 'features' => ['Wi-Fi', 'TV', 'Bathroom']],
                        ['id' => 'premium', 'slug' => 'premium', 'title' => 'Premium', 'features' => ['Wi-Fi', 'Balcony', 'View']],
                    ],
                    'infos' => [
                        ['id' => 'parking', 'heading' => 'Parking', 'text' => 'Parking is available directly at the property.', 'opened' => true],
                        ['id' => 'breakfast', 'heading' => 'Breakfast', 'text' => 'Breakfast is available daily from 7:00.'],
                    ],
                ],
            ],
            'room' => [
                'sk' => [
                    'title' => 'Štandardná izba',
                    'description' => 'Komfortná izba vhodná na krátkodobý aj dlhší pobyt.',
                    'images' => [
                        ['src' => '/assets/image.jpg', 'alt' => 'Štandardná izba'],
                        ['src' => '/assets/image2.jpg', 'alt' => 'Detail izby'],
                    ],
                    'sections' => [
                        ['id' => 'equipment', 'heading' => 'Vybavenie', 'rows' => [
                            ['id' => 'beds', 'label' => 'Postele', 'count' => 2],
                            ['id' => 'wifi', 'label' => 'Wi-Fi', 'checked' => true],
                            ['id' => 'bathroom', 'label' => 'Kúpeľňa', 'checked' => true],
                        ]],
                        ['id' => 'services', 'heading' => 'Služby', 'rows' => [
                            ['id' => 'breakfast', 'label' => 'Raňajky', 'checked' => true],
                            ['id' => 'parking', 'label' => 'Parkovanie', 'checked' => true],
                        ]],
                    ],
                ],
                'en' => [
                    'title' => 'Standard room',
                    'description' => 'A comfortable room suitable for short and longer stays.',
                    'images' => [
                        ['src' => '/assets/image.jpg', 'alt' => 'Standard room'],
                        ['src' => '/assets/image2.jpg', 'alt' => 'Room detail'],
                    ],
                    'sections' => [
                        ['id' => 'equipment', 'heading' => 'Equipment', 'rows' => [
                            ['id' => 'beds', 'label' => 'Beds', 'count' => 2],
                            ['id' => 'wifi', 'label' => 'Wi-Fi', 'checked' => true],
                            ['id' => 'bathroom', 'label' => 'Bathroom', 'checked' => true],
                        ]],
                        ['id' => 'services', 'heading' => 'Services', 'rows' => [
                            ['id' => 'breakfast', 'label' => 'Breakfast', 'checked' => true],
                            ['id' => 'parking', 'label' => 'Parking', 'checked' => true],
                        ]],
                    ],
                ],
            ],
        ];

        foreach ($pageContents as $pageKey => $locales) {
            foreach ($locales as $localeCode => $content) {
                $hotel->pageContents()->updateOrCreate(
                    ['page_key' => $pageKey, 'locale_code' => $localeCode],
                    ['content_json' => $content]
                );
            }
        }

        // Property content (translations, images, sections)
        $propertyContent = $hotel->propertyContent()->first();
        if (! $propertyContent) {
            $propertyContent = $hotel->propertyContent()->create([]);
        }

        $propertyTranslations = [
            ['locale_code' => 'sk', 'subtitle' => 'Hotel', 'description' => 'Objavte naše izby, vybavenie a služby, ktoré sú dostupné počas vášho pobytu.', 'compare_heading' => 'Porovnanie', 'compare_description' => 'Vyberte 2 typy izieb, ktoré chcete porovnať.'],
            ['locale_code' => 'en', 'subtitle' => 'Hotel', 'description' => 'Discover our rooms, amenities, and services available during your stay.', 'compare_heading' => 'Comparison', 'compare_description' => 'Choose 2 room types you want to compare.'],
        ];

        foreach ($propertyTranslations as $pt) {
            $propertyContent->translations()->updateOrCreate(
                ['locale_code' => $pt['locale_code']],
                ['subtitle' => $pt['subtitle'], 'description' => $pt['description'], 'compare_heading' => $pt['compare_heading'], 'compare_description' => $pt['compare_description']]
            );
        }

        $imageModels = [];
        $images = [
            ['src' => '/assets/image.jpg', 'alt' => ['sk' => 'Hotel', 'en' => 'Hotel']],
            ['src' => '/assets/image2.jpg', 'alt' => ['sk' => 'Izba', 'en' => 'Room']],
        ];

        foreach ($images as $idx => $img) {
            $m = $propertyContent->images()->updateOrCreate(['src' => $img['src']], ['sort_order' => $idx]);
            $m->translations()->updateOrCreate(['locale_code' => 'sk'], ['alt' => $img['alt']['sk']]);
            $m->translations()->updateOrCreate(['locale_code' => 'en'], ['alt' => $img['alt']['en']]);
            $imageModels[] = $m;
        }

        $sections = [
            ['slug' => 'amenities', 'heading' => ['sk' => 'Vybavenie', 'en' => 'Amenities'], 'rows' => [
                ['slug' => 'wifi', 'type' => 'check', 'label' => ['sk' => 'Wi-Fi', 'en' => 'Wi-Fi']],
                ['slug' => 'parking', 'type' => 'count', 'count' => 12, 'label' => ['sk' => 'Parkovanie', 'en' => 'Parking']],
                ['slug' => 'breakfast', 'type' => 'check', 'label' => ['sk' => 'Raňajky', 'en' => 'Breakfast']],
            ]],
            ['slug' => 'services', 'heading' => ['sk' => 'Služby', 'en' => 'Services'], 'rows' => [
                ['slug' => 'reception', 'type' => 'check', 'label' => ['sk' => 'Recepcia', 'en' => 'Reception']],
                ['slug' => 'cleaning', 'type' => 'check', 'label' => ['sk' => 'Upratovanie', 'en' => 'Cleaning']],
                ['slug' => 'pets', 'type' => 'check', 'label' => ['sk' => 'Domáce zvieratá', 'en' => 'Pets']],
            ]],
        ];

        foreach ($sections as $sidx => $section) {
            $s = $propertyContent->sections()->updateOrCreate(['slug' => $section['slug']], ['sort_order' => $sidx]);
            $s->translations()->updateOrCreate(['locale_code' => 'sk'], ['heading' => $section['heading']['sk']]);
            $s->translations()->updateOrCreate(['locale_code' => 'en'], ['heading' => $section['heading']['en']]);

            foreach ($section['rows'] as $ridx => $row) {
                $rowModel = $s->rows()->updateOrCreate(['slug' => $row['slug']], ['row_type' => $row['type'], 'count_value' => $row['count'] ?? null, 'sort_order' => $ridx]);
                $rowModel->translations()->updateOrCreate(['locale_code' => 'sk'], ['label' => $row['label']['sk']]);
                $rowModel->translations()->updateOrCreate(['locale_code' => 'en'], ['label' => $row['label']['en']]);
            }
        }

        // Features
        $features = [
            ['code' => 'wifi', 'label' => ['sk' => 'Wi-Fi', 'en' => 'Wi-Fi']],
            ['code' => 'tv', 'label' => ['sk' => 'TV', 'en' => 'TV']],
            ['code' => 'bathroom', 'label' => ['sk' => 'Kúpeľňa', 'en' => 'Bathroom']],
            ['code' => 'balcony', 'label' => ['sk' => 'Balkón', 'en' => 'Balcony']],
            ['code' => 'view', 'label' => ['sk' => 'Výhľad', 'en' => 'View']],
        ];

        $featureIds = [];
        foreach ($features as $fidx => $f) {
            $fm = $hotel->features()->updateOrCreate(['code' => $f['code']], ['sort_order' => $fidx]);
            $fm->translations()->updateOrCreate(['locale_code' => 'sk'], ['label' => $f['label']['sk']]);
            $fm->translations()->updateOrCreate(['locale_code' => 'en'], ['label' => $f['label']['en']]);
            $featureIds[$f['code']] = $fm->id;
        }

        // Room types
        $roomTypes = [
            ['slug' => 'standard', 'title' => ['sk' => 'Štandard', 'en' => 'Standard'], 'feature_codes' => ['wifi', 'tv', 'bathroom']],
            ['slug' => 'premium', 'title' => ['sk' => 'Premium', 'en' => 'Premium'], 'feature_codes' => ['wifi', 'tv', 'bathroom', 'balcony']],
            ['slug' => 'deluxe', 'title' => ['sk' => 'Deluxe', 'en' => 'Deluxe'], 'feature_codes' => ['wifi', 'tv', 'bathroom', 'balcony', 'view']],
        ];

        foreach ($roomTypes as $ridx => $rt) {
            $rtm = $hotel->roomTypes()->updateOrCreate(['slug' => $rt['slug']], ['sort_order' => $ridx, 'active' => true]);
            $rtm->translations()->updateOrCreate(['locale_code' => 'sk'], ['title' => $rt['title']['sk']]);
            $rtm->translations()->updateOrCreate(['locale_code' => 'en'], ['title' => $rt['title']['en']]);
            $attachIds = [];
            foreach ($rt['feature_codes'] as $code) {
                if (isset($featureIds[$code])) {
                    $attachIds[] = $featureIds[$code];
                }
            }
            if (!empty($attachIds)) {
                $rtm->features()->syncWithoutDetaching($attachIds);
            }
        }
    }
}
