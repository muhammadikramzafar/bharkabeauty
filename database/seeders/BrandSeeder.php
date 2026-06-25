<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('brands');

        $brands = [
            [
                'name'        => 'Huda Beauty',
                'slug'        => 'huda-beauty',
                'description' => 'Founded by Huda Kattan, Huda Beauty is a globally renowned cosmetics brand known for bold glam, eyeshadow palettes, and cult-favourite foundations.',
                'website'     => 'https://hudabeauty.com',
                'is_featured' => true,
                'sort_order'  => 1,
                'color'       => '#C9A96E',
                'text_color'  => '#FFFFFF',
                'initial'     => 'HB',
            ],
            [
                'name'        => 'Charlotte Tilbury',
                'slug'        => 'charlotte-tilbury',
                'description' => 'Charlotte Tilbury is a British luxury makeup brand celebrated for Pillow Talk, Hollywood Flawless Filter, and its iconic Magic Cream.',
                'website'     => 'https://charlottetilbury.com',
                'is_featured' => true,
                'sort_order'  => 2,
                'color'       => '#8B2252',
                'text_color'  => '#FFFFFF',
                'initial'     => 'CT',
            ],
            [
                'name'        => 'MAC Cosmetics',
                'slug'        => 'mac-cosmetics',
                'description' => 'MAC is a professional makeup brand trusted by makeup artists worldwide, famous for its extensive shade range and long-wear formulas.',
                'website'     => 'https://maccosmetics.com',
                'is_featured' => true,
                'sort_order'  => 3,
                'color'       => '#1A1A1A',
                'text_color'  => '#FFFFFF',
                'initial'     => 'MAC',
            ],
            [
                'name'        => 'NYX Professional Makeup',
                'slug'        => 'nyx',
                'description' => 'NYX Professional Makeup delivers high-performance, cruelty-free cosmetics at affordable prices, beloved by influencers and professionals alike.',
                'website'     => 'https://nyxcosmetics.com',
                'is_featured' => true,
                'sort_order'  => 4,
                'color'       => '#FF1493',
                'text_color'  => '#FFFFFF',
                'initial'     => 'NYX',
            ],
            [
                'name'        => 'Maybelline',
                'slug'        => 'maybelline',
                'description' => 'Maybelline New York is one of the world\'s leading cosmetic brands, offering makeup essentials from mascara to foundation at accessible prices.',
                'website'     => 'https://maybelline.com',
                'is_featured' => true,
                'sort_order'  => 5,
                'color'       => '#E30B17',
                'text_color'  => '#FFFFFF',
                'initial'     => 'MB',
            ],
            [
                'name'        => 'L\'Oréal Paris',
                'slug'        => 'loreal-paris',
                'description' => 'L\'Oréal Paris is a global leader in beauty, offering innovative skincare, haircare, and makeup products for all skin types.',
                'website'     => 'https://lorealparis.com',
                'is_featured' => true,
                'sort_order'  => 6,
                'color'       => '#C9A400',
                'text_color'  => '#FFFFFF',
                'initial'     => 'L\'O',
            ],
            [
                'name'        => 'Fenty Beauty',
                'slug'        => 'fenty-beauty',
                'description' => 'Rihanna\'s Fenty Beauty revolutionised the beauty industry with its groundbreaking 40-shade foundation range and inclusive approach.',
                'website'     => 'https://fentybeauty.com',
                'is_featured' => true,
                'sort_order'  => 7,
                'color'       => '#7B3F2E',
                'text_color'  => '#FFFFFF',
                'initial'     => 'FB',
            ],
            [
                'name'        => 'The Ordinary',
                'slug'        => 'the-ordinary',
                'description' => 'The Ordinary by Deciem offers clinical skincare at honest prices, with hero products like Niacinamide, Retinol, and AHA 30% peels.',
                'website'     => 'https://theordinary.com',
                'is_featured' => true,
                'sort_order'  => 8,
                'color'       => '#2D2D2D',
                'text_color'  => '#FFFFFF',
                'initial'     => 'TO',
            ],
            [
                'name'        => 'Neutrogena',
                'slug'        => 'neutrogena',
                'description' => 'Neutrogena is dermatologist-recommended, offering gentle and effective skincare solutions for cleansing, moisturising, and sun protection.',
                'website'     => 'https://neutrogena.com',
                'is_featured' => false,
                'sort_order'  => 9,
                'color'       => '#0066CC',
                'text_color'  => '#FFFFFF',
                'initial'     => 'NTG',
            ],
            [
                'name'        => 'Cetaphil',
                'slug'        => 'cetaphil',
                'description' => 'Cetaphil is trusted by dermatologists for sensitive skin care, known for its gentle, fragrance-free cleansers and moisturizers.',
                'website'     => 'https://cetaphil.com',
                'is_featured' => false,
                'sort_order'  => 10,
                'color'       => '#00A86B',
                'text_color'  => '#FFFFFF',
                'initial'     => 'CPH',
            ],
            [
                'name'        => 'Laneige',
                'slug'        => 'laneige',
                'description' => 'Korean beauty brand Laneige is celebrated for its Water Sleeping Mask and innovative hydration-focused skincare formulas.',
                'website'     => 'https://laneige.com',
                'is_featured' => false,
                'sort_order'  => 11,
                'color'       => '#7BB8D4',
                'text_color'  => '#FFFFFF',
                'initial'     => 'LNG',
            ],
            [
                'name'        => 'Lakme',
                'slug'        => 'lakme',
                'description' => 'Lakme is India\'s most trusted beauty brand, offering a wide range of makeup and skincare products tailored for South Asian skin tones.',
                'website'     => 'https://lakme.com',
                'is_featured' => false,
                'sort_order'  => 12,
                'color'       => '#FF69B4',
                'text_color'  => '#FFFFFF',
                'initial'     => 'LKM',
            ],
            [
                'name'        => 'Nykaa',
                'slug'        => 'nykaa',
                'description' => 'Nykaa is a homegrown beauty powerhouse known for its vibrant nail polishes, lipsticks, and skincare products for South Asian beauty lovers.',
                'website'     => 'https://nykaa.com',
                'is_featured' => false,
                'sort_order'  => 13,
                'color'       => '#FC2779',
                'text_color'  => '#FFFFFF',
                'initial'     => 'NKA',
            ],
            [
                'name'        => 'Bioderma',
                'slug'        => 'bioderma',
                'description' => 'Bioderma is a French skincare brand trusted by dermatologists, famous for its Micellar Water H2O and sensitive-skin formulations.',
                'website'     => 'https://bioderma.com',
                'is_featured' => false,
                'sort_order'  => 14,
                'color'       => '#E8863A',
                'text_color'  => '#FFFFFF',
                'initial'     => 'BDM',
            ],
        ];

        foreach ($brands as $brandData) {
            $color     = $brandData['color'];
            $textColor = $brandData['text_color'];
            $initial   = $brandData['initial'];
            $slug      = $brandData['slug'];

            unset($brandData['color'], $brandData['text_color'], $brandData['initial']);

            $logoPath = $this->generateSvgLogo($slug, $initial, $color, $textColor);

            Brand::create(array_merge($brandData, [
                'is_active' => true,
                'logo'      => $logoPath,
            ]));

            $this->command->info("  ✓ Brand: {$brandData['name']}");
        }

        $this->command->info('  Brands seeded successfully.');
    }

    private function generateSvgLogo(string $slug, string $initial, string $bgColor, string $textColor): string
    {
        $path = "brands/{$slug}.svg";
        $dest = storage_path("app/public/{$path}");

        $fontSize = strlen($initial) > 2 ? '28' : '34';

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 120" width="240" height="120">
  <defs>
    <linearGradient id="grad_{$slug}" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:{$bgColor};stop-opacity:1" />
      <stop offset="100%" style="stop-color:{$bgColor}CC;stop-opacity:1" />
    </linearGradient>
  </defs>
  <rect width="240" height="120" rx="12" fill="url(#grad_{$slug})"/>
  <rect x="0" y="0" width="240" height="120" rx="12" fill="rgba(255,255,255,0.08)"/>
  <text x="120" y="68" font-family="Georgia, 'Times New Roman', serif" font-size="{$fontSize}"
        font-weight="bold" fill="{$textColor}" text-anchor="middle"
        letter-spacing="2">{$initial}</text>
</svg>
SVG;

        file_put_contents($dest, $svg);
        return $path;
    }
}
