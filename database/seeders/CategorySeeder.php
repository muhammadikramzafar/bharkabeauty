<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('categories');

        $rootCategories = [
            [
                'name'        => 'Skincare',
                'slug'        => 'skincare',
                'description' => 'Nourish and protect your skin with our curated range of cleansers, moisturizers, serums, and treatments.',
                'sort_order'  => 1,
                'image_url'   => 'https://picsum.photos/seed/skincarebeauty/800/600',
                'children'    => [
                    ['name' => 'Moisturizers & Hydration', 'slug' => 'moisturizers', 'sort_order' => 1, 'image_url' => 'https://picsum.photos/seed/moisturizer/800/600'],
                    ['name' => 'Serums & Treatments',      'slug' => 'serums',        'sort_order' => 2, 'image_url' => 'https://picsum.photos/seed/serumface/800/600'],
                    ['name' => 'Sunscreen & SPF',          'slug' => 'sunscreen',     'sort_order' => 3, 'image_url' => 'https://picsum.photos/seed/sunscreenspf/800/600'],
                    ['name' => 'Cleansers & Toners',       'slug' => 'cleansers',     'sort_order' => 4, 'image_url' => 'https://picsum.photos/seed/cleanserface/800/600'],
                    ['name' => 'Eye Care',                 'slug' => 'eye-care',      'sort_order' => 5, 'image_url' => 'https://picsum.photos/seed/eyecarebeauty/800/600'],
                    ['name' => 'Face Masks',               'slug' => 'face-masks',    'sort_order' => 6, 'image_url' => 'https://picsum.photos/seed/facemaskbeauty/800/600'],
                ],
            ],
            [
                'name'        => 'Makeup',
                'slug'        => 'makeup',
                'description' => 'Discover foundations, lipsticks, eye palettes and everything you need to create any look.',
                'sort_order'  => 2,
                'image_url'   => 'https://picsum.photos/seed/makeupcosmetics/800/600',
                'children'    => [
                    ['name' => 'Foundation & Concealer', 'slug' => 'foundation',     'sort_order' => 1, 'image_url' => 'https://picsum.photos/seed/foundationmakeup/800/600'],
                    ['name' => 'Lipstick & Lip Gloss',   'slug' => 'lipstick',       'sort_order' => 2, 'image_url' => 'https://picsum.photos/seed/lipstickred/800/600'],
                    ['name' => 'Eye Makeup',              'slug' => 'eye-makeup',     'sort_order' => 3, 'image_url' => 'https://picsum.photos/seed/eyeshadowmakeup/800/600'],
                    ['name' => 'Blush & Bronzer',         'slug' => 'blush-bronzer',  'sort_order' => 4, 'image_url' => 'https://picsum.photos/seed/blushbronzer/800/600'],
                    ['name' => 'Setting & Primer',        'slug' => 'setting-primer', 'sort_order' => 5, 'image_url' => 'https://picsum.photos/seed/primerface/800/600'],
                ],
            ],
            [
                'name'        => 'Haircare',
                'slug'        => 'haircare',
                'description' => 'From nourishing shampoos to intensive masks, give your hair the care it deserves.',
                'sort_order'  => 3,
                'image_url'   => 'https://picsum.photos/seed/haircaresalon/800/600',
                'children'    => [
                    ['name' => 'Shampoo & Conditioner',   'slug' => 'shampoo-conditioner',  'sort_order' => 1, 'image_url' => 'https://picsum.photos/seed/shampoohair/800/600'],
                    ['name' => 'Hair Masks & Treatments', 'slug' => 'hair-masks',            'sort_order' => 2, 'image_url' => 'https://picsum.photos/seed/hairmaskhair/800/600'],
                    ['name' => 'Hair Styling',            'slug' => 'hair-styling',          'sort_order' => 3, 'image_url' => 'https://picsum.photos/seed/hairstyling/800/600'],
                    ['name' => 'Hair Oils & Serums',      'slug' => 'hair-oils',             'sort_order' => 4, 'image_url' => 'https://picsum.photos/seed/hairoil/800/600'],
                ],
            ],
            [
                'name'        => 'Fragrance',
                'slug'        => 'fragrance',
                'description' => 'Explore our edit of luxury perfumes and body sprays for every mood and occasion.',
                'sort_order'  => 4,
                'image_url'   => 'https://picsum.photos/seed/fragranceperfume/800/600',
                'children'    => [
                    ['name' => 'Women\'s Perfume', 'slug' => 'womens-perfume', 'sort_order' => 1, 'image_url' => 'https://picsum.photos/seed/womanperfume/800/600'],
                    ['name' => 'Men\'s Cologne',   'slug' => 'mens-cologne',   'sort_order' => 2, 'image_url' => 'https://picsum.photos/seed/menperfume/800/600'],
                    ['name' => 'Body Sprays',      'slug' => 'body-sprays',    'sort_order' => 3, 'image_url' => 'https://picsum.photos/seed/bodyspray/800/600'],
                ],
            ],
            [
                'name'        => 'Body Care',
                'slug'        => 'body-care',
                'description' => 'Pamper your body from head to toe with luxurious lotions, scrubs, and bath essentials.',
                'sort_order'  => 5,
                'image_url'   => 'https://picsum.photos/seed/bodycarelotion/800/600',
                'children'    => [
                    ['name' => 'Body Lotions & Oils', 'slug' => 'body-lotions',   'sort_order' => 1, 'image_url' => 'https://picsum.photos/seed/bodylotion/800/600'],
                    ['name' => 'Bath & Shower',       'slug' => 'bath-shower',    'sort_order' => 2, 'image_url' => 'https://picsum.photos/seed/bathshower/800/600'],
                    ['name' => 'Hand & Foot Care',    'slug' => 'hand-foot-care', 'sort_order' => 3, 'image_url' => 'https://picsum.photos/seed/handcare/800/600'],
                    ['name' => 'Body Scrubs',         'slug' => 'body-scrubs',    'sort_order' => 4, 'image_url' => 'https://picsum.photos/seed/bodyscrub/800/600'],
                ],
            ],
            [
                'name'        => 'Nail Care',
                'slug'        => 'nail-care',
                'description' => 'Express yourself with nail polishes, treatments, and tools for salon-worthy results at home.',
                'sort_order'  => 6,
                'image_url'   => 'https://picsum.photos/seed/nailpolishcare/800/600',
                'children'    => [
                    ['name' => 'Nail Polish',      'slug' => 'nail-polish',     'sort_order' => 1, 'image_url' => 'https://picsum.photos/seed/nailpolish/800/600'],
                    ['name' => 'Nail Treatments',  'slug' => 'nail-treatments', 'sort_order' => 2, 'image_url' => 'https://picsum.photos/seed/nailtreatment/800/600'],
                    ['name' => 'Nail Art',         'slug' => 'nail-art',        'sort_order' => 3, 'image_url' => 'https://picsum.photos/seed/nailart/800/600'],
                ],
            ],
            [
                'name'        => 'Tools & Brushes',
                'slug'        => 'tools-brushes',
                'description' => 'Professional brushes, applicators, and beauty tools for a flawless finish every time.',
                'sort_order'  => 7,
                'image_url'   => 'https://picsum.photos/seed/makeupbrushes/800/600',
                'children'    => [
                    ['name' => 'Makeup Brushes',    'slug' => 'makeup-brushes',  'sort_order' => 1, 'image_url' => 'https://picsum.photos/seed/makeupbrush/800/600'],
                    ['name' => 'Skincare Devices',  'slug' => 'skincare-devices','sort_order' => 2, 'image_url' => 'https://picsum.photos/seed/skincaredevice/800/600'],
                    ['name' => 'Hair Tools',        'slug' => 'hair-tools',      'sort_order' => 3, 'image_url' => 'https://picsum.photos/seed/hairtool/800/600'],
                ],
            ],
        ];

        foreach ($rootCategories as $rootData) {
            $children = $rootData['children'] ?? [];
            unset($rootData['children']);

            $imagePath = $this->downloadImage($rootData['image_url'], 'categories', $rootData['slug']);
            unset($rootData['image_url']);

            $parent = Category::create(array_merge($rootData, [
                'is_active' => true,
                'image'     => $imagePath,
            ]));

            $this->command->info("  ✓ Category: {$parent->name}");

            foreach ($children as $childData) {
                $childImagePath = $this->downloadImage($childData['image_url'], 'categories', $childData['slug']);
                unset($childData['image_url']);

                Category::create(array_merge($childData, [
                    'parent_id' => $parent->id,
                    'is_active' => true,
                    'image'     => $childImagePath,
                ]));
                $this->command->line("      → {$childData['name']}");
            }
        }

        $this->command->info('  Categories seeded successfully.');
    }

    private function downloadImage(string $url, string $folder, string $filename): ?string
    {
        $ext  = 'jpg';
        $path = "{$folder}/{$filename}.{$ext}";
        $dest = storage_path("app/public/{$path}");

        if (file_exists($dest)) {
            return $path;
        }

        try {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT        => 15,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_USERAGENT      => 'Mozilla/5.0 (Amsaz Cosmetics/1.0)',
            ]);
            $data = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($data && $code === 200) {
                file_put_contents($dest, $data);
                return $path;
            }
        } catch (\Throwable) {}

        return null;
    }
}
