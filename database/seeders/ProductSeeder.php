<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    private array $cats   = [];
    private array $brands = [];

    public function run(): void
    {
        Storage::disk('public')->makeDirectory('products');

        Category::all()->each(fn ($c) => $this->cats[$c->slug]   = $c->id);
        Brand::all()->each(fn ($b)    => $this->brands[$b->slug] = $b->id);

        foreach ($this->products() as $data) {
            $this->seed($data);
        }

        $this->command->info('  ' . Product::count() . ' products seeded.');
    }

    /* ─────────────────────────────────────────────────────────── */

    private function seed(array $d): void
    {
        $slug = Str::slug($d['name']);
        $img  = $this->download("https://picsum.photos/seed/{$slug}/800/800", $slug);

        $product = Product::create([
            'category_id'       => $this->cats[$d['cat']]     ?? null,
            'brand_id'          => $this->brands[$d['brand']] ?? null,
            'name'              => $d['name'],
            'slug'              => $slug,
            'sku'               => strtoupper(str_replace(' ', '', substr($d['name'], 0, 4))) . '-' . rand(1000, 9999),
            'short_description' => $d['short'],
            'description'       => $d['desc'],
            'price'             => $d['price'],
            'sale_price'        => $d['sale'] ?? null,
            'stock_qty'         => rand(15, 120),
            'images'            => $img ? [$img] : [],
            'is_featured'       => $d['featured'] ?? false,
            'is_active'         => true,
            'sort_order'        => 0,
            'seo_title'         => $d['name'] . ' | BharkaBeauty',
            'seo_description'   => $d['short'],
        ]);

        $this->command->line("  ✓ {$product->name}");
    }

    private function download(string $url, string $name): ?string
    {
        $path = "products/{$name}.jpg";
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
                CURLOPT_USERAGENT      => 'Mozilla/5.0 BharkaBeauty/1.0',
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

    /* ─────────────────────────────────────────────────────────── */
    /*  PRODUCTS                                                   */
    /* ─────────────────────────────────────────────────────────── */

    private function products(): array
    {
        return [

            /* ═══════════════ SKINCARE ═══════════════ */

            [
                'name'     => 'Hydro Boost Water Gel Moisturizer',
                'cat'      => 'moisturizers',
                'brand'    => 'neutrogena',
                'short'    => 'Lightweight water-gel formula that absorbs instantly to quench dry skin and keep it looking smooth, supple, and hydrated all day.',
                'desc'     => 'Neutrogena Hydro Boost Water Gel is a unique, oil-free moisturiser with hyaluronic acid that locks in moisture 24 hours a day. Its refreshing, fast-absorbing gel formula transforms into a burst of hydration the moment it touches your skin. Suitable for all skin types, including oily skin. Dermatologist tested and non-comedogenic. Use morning and evening after cleansing for best results.',
                'price'    => 2999,
                'sale'     => 2499,
                'featured' => true,
            ],
            [
                'name'     => 'Niacinamide 10% + Zinc 1% Serum',
                'cat'      => 'serums',
                'brand'    => 'the-ordinary',
                'short'    => 'High-strength vitamin and mineral blemish formula that visibly reduces blemishes, pore size, and improves skin clarity.',
                'desc'     => 'The Ordinary Niacinamide 10% + Zinc 1% targets textural irregularities and the look of blemishes and congestion. Niacinamide (Vitamin B3) is an effective water-soluble vitamin that works with the natural substances in your skin to minimise enlarged pores, tighten lax pores, improve uneven skin tone, soften fine lines and wrinkles, and diminish dullness. This formula combines it with a balancing amount of zinc salt of pyrrolidone carboxylic acid to regulate zinc levels in the skin.',
                'price'    => 1850,
                'featured' => true,
            ],
            [
                'name'     => 'Vitamin C 23% + HA Spheres 2% Suspension',
                'cat'      => 'serums',
                'brand'    => 'the-ordinary',
                'short'    => 'Potent antioxidant vitamin C formula that visibly brightens skin tone and targets signs of ageing with 23% pure L-Ascorbic Acid.',
                'desc'     => 'The Ordinary Ascorbic Acid 8% + Alpha Arbutin 2% is a water-based formula combining Ascorbic Acid with Alpha Arbutin to target and reduce the appearances of uneven skin tone in a brightening formula. 23% pure Vitamin C in a stable suspension with Hyaluronic Acid spheres helps brighten the skin and reduce the appearance of fine lines over time. Suitable for normal, dry, and combination skin.',
                'price'    => 2200,
                'sale'     => 1890,
            ],
            [
                'name'     => 'Ultra Sheer Dry-Touch Sunscreen SPF 50+',
                'cat'      => 'sunscreen',
                'brand'    => 'neutrogena',
                'short'    => 'Lightweight, non-greasy SPF 50+ sunscreen with Dry-Touch technology that leaves skin with a clean, matte finish.',
                'desc'     => 'Neutrogena Ultra Sheer Dry-Touch Sunscreen SPF 50+ provides superior sun protection in an ultra-light formula. Helioplex Technology provides outstanding balanced UVA/UVB protection. The Dry-Touch formula absorbs quickly and leaves skin feeling clean and comfortable with a matte finish. Water-resistant for up to 80 minutes. Apply liberally 15 minutes before sun exposure. Reapply every 2 hours or after towel drying.',
                'price'    => 2800,
                'featured' => true,
            ],
            [
                'name'     => 'Sensibio H2O Micellar Water',
                'cat'      => 'cleansers',
                'brand'    => 'bioderma',
                'short'    => 'France\'s No.1 gentle micellar water that cleanses, removes makeup, and soothes sensitive skin without rinsing.',
                'desc'     => 'Bioderma Sensibio H2O is the reference micellar solution for sensitive skin. Its biological formula is perfectly tolerated even by the most sensitive skin. Its exclusive combination of ingredients perfectly mimics the structure of cell membranes, gently cleansing the skin while protecting its natural balance. The unique Sensibio formula with its D.A.F (Dermatological Advancing Formula) helps soothe and even tone the skin. No rinse needed.',
                'price'    => 3500,
                'sale'     => 2999,
                'featured' => true,
            ],
            [
                'name'     => 'Gentle Skin Cleanser Daily Facial Wash',
                'cat'      => 'cleansers',
                'brand'    => 'cetaphil',
                'short'    => 'Dermatologist-recommended gentle daily cleanser that effectively removes dirt, oil, and makeup without over-drying.',
                'desc'     => 'Cetaphil Gentle Skin Cleanser is a non-irritating, soap-free formula that cleans without stripping your skin of its natural protective oils. It effectively removes dirt, make-up and excess oil while maintaining the skin\'s natural pH balance. Suitable for all skin types, this fragrance-free formula is hypoallergenic and non-comedogenic. Used and recommended by dermatologists and paediatricians worldwide. Suitable for face and body.',
                'price'    => 1800,
            ],
            [
                'name'     => 'Hyaluronic Acid 2% + B5 Hydration Support',
                'cat'      => 'serums',
                'brand'    => 'the-ordinary',
                'short'    => 'Multi-depth hydration serum with pure Hyaluronic Acid to visibly plump skin and support surface smoothness.',
                'desc'     => 'The Ordinary Hyaluronic Acid 2% + B5 supports multiple layers of skin moisture with a formula combining low, medium, and high molecular weight hyaluronic acids and a next-generation hyaluronic acid crosspolymer. The addition of pro-vitamin B5 enhances surface hydration. This formula is built with a multi-depth approach to replenish skin hydration and help lock-in moisture. Use morning and night after water-based serums, before heavier treatments.',
                'price'    => 1650,
            ],
            [
                'name'     => 'Water Sleeping Mask Overnight Hydration',
                'cat'      => 'face-masks',
                'brand'    => 'laneige',
                'short'    => 'Bestselling overnight sleeping mask that intensely moisturises while you sleep, leaving skin soft and bright by morning.',
                'desc'     => 'Laneige Water Sleeping Mask is the original and iconic overnight facial mask that deeply moisturises and refreshes dull, tired skin overnight. Infused with SLEEPSCENT technology — a blend of Evening Primrose, Orange Flower, Sandalwood, and Ylang Ylang fragrance — it promotes comfortable sleep while the Hydro Ionized Mineral Water and Sleep-Biome complex deeply hydrates. Wake up to visibly soft, supple, and radiant skin. No rinse needed.',
                'price'    => 5200,
                'featured' => true,
            ],
            [
                'name'     => 'Eye Cream Magic Eye Rescue',
                'cat'      => 'eye-care',
                'brand'    => 'charlotte-tilbury',
                'short'    => 'Luxurious multi-tasking eye cream that targets dark circles, puffiness, and fine lines for bright, youthful-looking eyes.',
                'desc'     => 'Charlotte Tilbury Magic Eye Rescue is a rich, regenerating eye cream supercharged with Charlotte\'s magic anti-ageing ingredients, including peptides, caffeine, and hyaluronic acid. This luxurious formula is clinically proven to reduce the appearance of dark circles, puffiness, and fine lines in just 4 weeks. The unique Collagen Surge Complex works to plump skin and the Reflective Micro-Pigments instantly brighten the eye area. For use morning and evening.',
                'price'    => 8900,
                'sale'     => 7500,
                'featured' => true,
            ],
            [
                'name'     => 'Moisture Surge 72-Hour Auto-Replenishing Hydrator',
                'cat'      => 'moisturizers',
                'brand'    => 'laneige',
                'short'    => 'Oil-free gel moisturizer that auto-replenishes hydration for 72 hours, leaving skin looking plump, refreshed, and dewy.',
                'desc'     => 'Laneige Moisture Surge 72-Hour Auto-Replenishing Hydrator is a lightweight yet intensely hydrating gel moisturizer. Its innovative formula creates an internal reservoir that continuously auto-replenishes moisture in your skin for a full 72 hours. Infused with skin-boosting ingredients including Activated Water, Aloe Water, and caffeine, it instantly quenches skin and gives it a healthy-looking glow. Oil-free, non-comedogenic. Suitable for all skin types.',
                'price'    => 5800,
                'sale'     => 4999,
            ],

            /* ═══════════════ MAKEUP ═══════════════ */

            [
                'name'     => 'Studio Fix Fluid SPF 15 Foundation',
                'cat'      => 'foundation',
                'brand'    => 'mac-cosmetics',
                'short'    => 'Medium-to-full buildable coverage foundation with a natural matte finish and 24-hour wear for a flawless, skin-like look.',
                'desc'     => 'MAC Studio Fix Fluid SPF 15 Foundation delivers medium-to-full buildable coverage in one application. This long-wearing formula provides a natural matte finish that controls shine all day without drying skin. The lightweight formula blends seamlessly into the skin for a natural, second-skin look. Features SPF 15 sun protection. Available in 67 shades to match every skin tone. Oil-free, fragrance-free, and dermatologist tested. Water-resistant formula.',
                'price'    => 6500,
                'featured' => true,
            ],
            [
                'name'     => 'Fit Me Matte + Poreless Foundation',
                'cat'      => 'foundation',
                'brand'    => 'maybelline',
                'short'    => 'Lightweight matte foundation that mattifies and minimizes the look of pores for a natural, skin-like finish.',
                'desc'     => 'Maybelline Fit Me Matte + Poreless Foundation blends right into your skin, creating a natural, smooth finish with a light-to-medium coverage. The formula contains micro-powders that smooth the look of pores and refine skin texture. Fits 80% of North American face shapes. Oil-free and non-comedogenic formula. Up to 8 hours of oil control. Available in 40 shades from fair to deep, covering a wide range of undertones. Ideal for normal to oily skin types.',
                'price'    => 2200,
                'sale'     => 1799,
                'featured' => true,
            ],
            [
                'name'     => 'Pillow Talk Lipstick',
                'cat'      => 'lipstick',
                'brand'    => 'charlotte-tilbury',
                'short'    => 'The iconic nude-pink lipstick beloved by celebrities worldwide, in Charlotte\'s original "dreamiest" shade.',
                'desc'     => 'Charlotte Tilbury Matte Revolution Lipstick in Pillow Talk is the iconic nude-pink lipstick that has become a global phenomenon. This bestselling shade — a dreamy, rosy nude — enhances natural lip colour with a hint of rosiness that flatters every skin tone. The Matte Revolution formula is enriched with Botanic Complex and Hyaluronic Filling Spheres that fill and plump lips while conditioning and hydrating. Delivers high colour payoff with a comfortable matte finish that lasts up to 8 hours.',
                'price'    => 9500,
                'sale'     => 8200,
                'featured' => true,
            ],
            [
                'name'     => 'Huda Beauty Lip Contour 2.0 Lip Pencil',
                'cat'      => 'lipstick',
                'brand'    => 'huda-beauty',
                'short'    => 'Creamy, ultra-pigmented lip liner that creates perfectly defined, fuller-looking lips with long-lasting colour.',
                'desc'     => 'Huda Beauty Lip Contour 2.0 is the next generation of the cult-favourite lip liner that defines, shapes, and perfects the lips. This super-creamy, ultra-pigmented formula goes on smoothly without dragging, and the long-lasting formula stays in place for hours. Use alone for a matte pop of colour, or pair with your favourite lip gloss for a fuller look. Retractable pencil design for precise application. Available in 30+ shades ranging from nudes to bold brights.',
                'price'    => 4800,
                'sale'     => 4200,
            ],
            [
                'name'     => 'Rose Gold Remastered Eyeshadow Palette',
                'cat'      => 'eye-makeup',
                'brand'    => 'huda-beauty',
                'short'    => 'The iconic 18-shade eyeshadow palette featuring Huda\'s signature shimmery metallics, glitters, and matte neutrals.',
                'desc'     => 'Huda Beauty Rose Gold Remastered Eyeshadow Palette is the iconic global bestseller reimagined with a new collection of 18 shades. The palette features a mix of shimmery metallics, shimmering glitters, and matte neutral shades in warm rose gold tones. Formulated with a unique blend of oils, waxes, and high-impact colour pigments for silky-smooth application and intense payoff. The shadows blend effortlessly and last all day without creasing or fading.',
                'price'    => 12500,
                'sale'     => 10800,
                'featured' => true,
            ],
            [
                'name'     => 'NYX Professional Suede Matte Lip Liner',
                'cat'      => 'lipstick',
                'brand'    => 'nyx',
                'short'    => 'Ultra-matte lip liner with a velvety suede finish that provides long-lasting colour and perfect lip definition.',
                'desc'     => 'NYX Professional Makeup Suede Matte Lip Liner is a velvety, ultra-matte lip liner that delivers intense colour payoff in one swipe. The creamy, smooth formula glides on effortlessly without skipping or pulling. Use it to line, define, and fill in your lips for an all-matte look that lasts all day. The Vitamin E-enriched formula keeps lips conditioned and comfortable. Available in 35+ shades from classic nudes to bold berry tones. Cruelty-free formula.',
                'price'    => 1800,
            ],
            [
                'name'     => 'Pro Filt\'r Soft Matte Longwear Foundation',
                'cat'      => 'foundation',
                'brand'    => 'fenty-beauty',
                'short'    => 'Revolutionary full-coverage, skin-perfecting foundation that stays fresh for 24 hours in 50 inclusive shades.',
                'desc'     => 'Fenty Beauty Pro Filt\'r Soft Matte Longwear Foundation changed the game with its groundbreaking 50-shade range. This full-coverage foundation provides a skin-perfecting, soft matte finish that photographs beautifully and lasts all day without fading, oxidising, or transferring. The lightweight formula is comfortable enough to wear all day and is suitable for all skin types, especially normal to oily skin. Oil-free and buildable to your desired coverage level.',
                'price'    => 8900,
                'sale'     => 7800,
                'featured' => true,
            ],
            [
                'name'     => 'Stunna Lip Paint Longwear Lip Colour',
                'cat'      => 'lipstick',
                'brand'    => 'fenty-beauty',
                'short'    => 'Universal red lipstick by Rihanna that complements every skin tone with a bold, long-wearing matte formula.',
                'desc'     => 'Fenty Beauty Stunna Lip Paint is the iconic universal red lip colour created by Rihanna. The award-winning formula provides intense, full-coverage colour in one stroke that lasts up to 12 hours without fading, cracking, or feathering. The applicator is designed to give precise application with a flat, domed tip. Lightweight, comfortable formula that stays fresh all day. 100% vegan and cruelty-free. The perfect red for every skin tone.',
                'price'    => 5500,
            ],
            [
                'name'     => 'Vivid Brighter Liner Graphic Eye Liner',
                'cat'      => 'eye-makeup',
                'brand'    => 'nyx',
                'short'    => 'Highly saturated, metallic eyeliner that delivers vivid, long-wearing colour for bold graphic eye looks.',
                'desc'     => 'NYX Professional Makeup Vivid Brighter Liner is a highly pigmented, liquid eyeliner that delivers an intense shot of colour. The precise pointed tip allows for detailed work and precise application, from thin subtle lines to bold graphic looks. Long-wearing, water-resistant formula that glides on smoothly and dries to a bold, vibrant finish. Does not smudge or transfer once dry. Available in a range of vivid, electric shades. Cruelty-free formula.',
                'price'    => 1500,
            ],
            [
                'name'     => 'Hollywood Flawless Filter Complexion Booster',
                'cat'      => 'setting-primer',
                'brand'    => 'charlotte-tilbury',
                'short'    => 'Award-winning complexion booster that filters out imperfections and gives skin a luminous, camera-ready glow.',
                'desc'     => 'Charlotte Tilbury Hollywood Flawless Filter is the multi-tasking complexion booster that works as a primer, highlighter, and skin-perfecting liquid filter all in one. Formulated with light-diffusing pigments and skin-loving ingredients, it blurs pores and imperfections for a flawless, luminous finish. Use alone for a dewy, no-makeup look, mix into your foundation for enhanced glow, or apply on top of makeup to highlight cheekbones and the high points of the face.',
                'price'    => 8200,
                'sale'     => 7100,
                'featured' => true,
            ],

            /* ═══════════════ HAIRCARE ═══════════════ */

            [
                'name'     => 'Elvive Extraordinary Oil Nourishing Shampoo',
                'cat'      => 'shampoo-conditioner',
                'brand'    => 'loreal-paris',
                'short'    => 'Luxurious shampoo enriched with 6 rare flower oils that nourish dull, lifeless hair for silky-smooth, shiny locks.',
                'desc'     => 'L\'Oréal Paris Elvive Extraordinary Oil Nourishing Shampoo is enriched with 6 rare flower oils including Rosewood, Camellia, Lotus, Tiare Flower, Rose, and Sunflower oils. This luxurious formula gently cleanses while infusing hair with intense nourishment, leaving it incredibly soft, silky, and shiny. Suitable for normal to dry hair types. The weightless formula does not weigh hair down. Follow with the Extraordinary Oil Conditioner for best results.',
                'price'    => 2200,
                'featured' => true,
            ],
            [
                'name'     => 'Total Repair 5 Repairing Shampoo',
                'cat'      => 'shampoo-conditioner',
                'brand'    => 'loreal-paris',
                'short'    => 'Strengthening shampoo that targets 5 signs of damaged hair: weakness, roughness, dullness, split ends, and dehydration.',
                'desc'     => 'L\'Oréal Paris Elvive Total Repair 5 Shampoo is specially formulated to repair and strengthen damaged, fragile hair. Its pro-keratin and ceramide formula targets the 5 signs of damaged hair: weakness, roughness, dullness, dryness, and split ends. The shampoo gently cleanses while repairing the inner structure of the hair fibre from within. After just one use, hair is visibly smoother, stronger, and more resistant to breakage. For all types of damaged hair.',
                'price'    => 1800,
            ],
            [
                'name'     => 'Dream Lengths Restoring Hair Mask',
                'cat'      => 'hair-masks',
                'brand'    => 'loreal-paris',
                'short'    => 'Intensive hair mask with castor oil and fine cashmere that repairs split ends and restores long, damaged hair.',
                'desc'     => 'L\'Oréal Paris Elvive Dream Lengths Hair Mask is a nourishing, restoring hair treatment specifically designed for long hair with damaged ends. Infused with Castor Oil and Fine Cashmere, this intensive mask penetrates deeply to repair split ends and restore hair\'s natural shine and strength. Apply to towel-dried hair, leave for 3-5 minutes, then rinse. With regular use, it helps prevent future split ends and keeps long hair looking healthy and strong.',
                'price'    => 2200,
                'sale'     => 1899,
            ],
            [
                'name'     => 'Extraordinary Oil Hair Serum',
                'cat'      => 'hair-oils',
                'brand'    => 'loreal-paris',
                'short'    => 'Luxurious hair serum with rare flower oils that instantly eliminates frizz and adds brilliant shine to all hair types.',
                'desc'     => 'L\'Oréal Paris Elvive Extraordinary Oil Hair Serum is a luxurious blend of 6 rare flower oils in an ultra-light, non-greasy formula. Just a few drops eliminate frizz, add brilliant shine, and provide intense nourishment without weighing hair down. Can be used on wet or dry hair. Apply to the mid-lengths and ends of hair and style as usual. The serum creates a protective barrier around each strand, shielding hair from humidity and environmental damage.',
                'price'    => 3200,
                'sale'     => 2799,
                'featured' => true,
            ],
            [
                'name'     => 'Triple Nutrition Curl Mantra Butter-Cream',
                'cat'      => 'hair-masks',
                'brand'    => 'neutrogena',
                'short'    => 'Rich, nourishing hair butter-cream that defines curls, reduces frizz, and adds intense moisture to curly and coily hair.',
                'desc'     => 'A deeply moisturising hair butter-cream specially formulated for curly and coily hair textures. Enriched with a trio of natural butters — Shea, Coconut, and Castor — this rich treatment defines curl pattern, eliminates frizz, and adds intense moisture without leaving residue. The lightweight formula absorbs quickly and leaves curls soft, bouncy, and defined. Use as a deep conditioning treatment or leave-in styler for perfectly defined, healthy-looking curls.',
                'price'    => 1600,
            ],
            [
                'name'     => 'Glossy Rinse Conditioning Hair Treatment',
                'cat'      => 'hair-masks',
                'brand'    => 'laneige',
                'short'    => 'Quick-rinse conditioning treatment that instantly boosts shine, smoothness, and manageability with every wash.',
                'desc'     => 'A lightweight, rinse-out conditioning treatment that transforms dull, tangled hair into glossy, smooth strands in just 1 minute. Infused with Moisture Wrap Technology and silk amino acids, this treatment coats each hair strand to seal the cuticle, boost shine, and eliminate frizz. Ideal for daily use, the weightless formula conditions without buildup, leaving hair incredibly soft, silky, and manageable. Suitable for all hair types, including fine and colour-treated hair.',
                'price'    => 3800,
                'sale'     => 3299,
            ],
            [
                'name'     => 'Silk & Gloss Hair Styling Cream',
                'cat'      => 'hair-styling',
                'brand'    => 'loreal-paris',
                'short'    => 'Multi-benefit styling cream that tames frizz, adds shine, and provides flexible hold for smooth, polished hairstyles.',
                'desc'     => 'L\'Oréal Paris Studio Line Silk & Gloss Smoothing Cream is a versatile styling product that controls frizz and adds brilliant shine. The lightweight, non-sticky formula provides flexible hold, allowing you to restyle without residue. Enriched with silk proteins that smooth the hair cuticle for a sleek, polished finish. Can be used on wet hair before blow-drying or applied to dry hair for touch-ups and finishing. Suitable for all hair types.',
                'price'    => 2500,
            ],
            [
                'name'     => 'Power Moisture Hair Mask Deep Conditioner',
                'cat'      => 'hair-masks',
                'brand'    => 'neutrogena',
                'short'    => 'Intensive moisturising hair mask that penetrates deeply to repair dry, damaged hair and restore its natural beauty.',
                'desc'     => 'A deeply penetrating hair mask formulated to restore moisture, shine, and softness to dry, damaged hair. The rich, creamy formula is packed with conditioning agents that work deep within the hair shaft to repair damage from heat styling, chemical treatments, and environmental stress. Glycerin and natural oils provide long-lasting hydration while proteins strengthen the hair structure to prevent future breakage. Use weekly for best results. Leaves hair visibly healthier and more manageable.',
                'price'    => 1600,
            ],
            [
                'name'     => 'Argan Oil of Morocco Hair Treatment Oil',
                'cat'      => 'hair-oils',
                'brand'    => 'loreal-paris',
                'short'    => 'Pure, lightweight Argan oil treatment that instantly smooths frizz, adds shine, and conditions dry, damaged hair.',
                'desc'     => 'L\'Oréal Paris Extraordinary Oil Argan Treatment is a 100% pure, lightweight hair oil derived from Moroccan Argan trees. This precious oil is rich in Vitamin E and fatty acids that deeply nourish and condition hair from root to tip. Just 2-3 drops on dry or damp hair instantly smooth frizz, add intense shine, and soften dry, damaged strands. The non-greasy formula absorbs quickly without weighing hair down. Safe for colour-treated and chemically processed hair.',
                'price'    => 2800,
                'sale'     => 2399,
                'featured' => true,
            ],
            [
                'name'     => 'Total Repair 5 Damage Erasing Balm',
                'cat'      => 'hair-masks',
                'brand'    => 'loreal-paris',
                'short'    => 'Leave-in treatment balm that repairs and protects damaged hair against the 5 signs of damage with every application.',
                'desc'     => 'L\'Oréal Paris Elvive Total Repair 5 Damage Erasing Balm is a concentrated leave-in treatment that continuously repairs and protects hair against damage throughout the day. Apply to towel-dried hair and do not rinse. The Pro-Keratin and Ceramide formula rebuilds the hair structure and creates a protective shield against future damage from heat, styling, and environmental factors. Suitable for very damaged hair that needs intensive repair and ongoing protection.',
                'price'    => 3500,
                'sale'     => 2999,
            ],

            /* ═══════════════ FRAGRANCE ═══════════════ */

            [
                'name'     => 'Kayali Eden Juicy Apple 01 Eau de Parfum',
                'cat'      => 'womens-perfume',
                'brand'    => 'huda-beauty',
                'short'    => 'A vibrant, fruity-floral fragrance by Huda\'s sister Mona that opens with crisp apple and dries down to warm, cosy musk.',
                'desc'     => 'Kayali by Huda Beauty Eden Juicy Apple 01 is a playful, vibrant fragrance that captures the essence of a juicy, freshly-picked apple. The top notes of Crisp Apple and Plum open with an energizing burst of fruitiness, while the heart of Tuberose and Violet give way to a sensual, feminine floral. The dry-down of Sandalwood, Vanilla, and White Musk creates a warm, inviting finish that lingers beautifully. A fragrance for the free-spirited and the joyful. 50ml Eau de Parfum.',
                'price'    => 15000,
                'sale'     => 13500,
                'featured' => true,
            ],
            [
                'name'     => 'Kayali Vanilla 28 Eau de Parfum',
                'cat'      => 'womens-perfume',
                'brand'    => 'huda-beauty',
                'short'    => 'A rich, addictive vanilla-based fragrance layered with warm gourmand notes for an irresistible, long-lasting scent.',
                'desc'     => 'Kayali by Huda Beauty Vanilla 28 is an intoxicating, gourmand fragrance that celebrates the rich, warm scent of pure vanilla. The top notes of Bergamot and Sweet Vanilla are followed by a heart of Heliotrope and Tonka Bean, creating a creamy, addictive depth. The base of White Musk and Amber gives it a warm, skin-like quality that lasts for hours. Suitable for wearing day or night, and beautifully layered with other Kayali fragrances. 50ml Eau de Parfum.',
                'price'    => 17500,
                'featured' => true,
            ],
            [
                'name'     => 'Nomadic Adventure Pour Homme Fragrance',
                'cat'      => 'mens-cologne',
                'brand'    => 'huda-beauty',
                'short'    => 'A bold, adventurous masculine fragrance with woody, aromatic notes that command attention all day.',
                'desc'     => 'A confident, modern masculine fragrance designed for the adventurous spirit. Opens with vibrant citrus notes of Bergamot and Grapefruit that energise the senses. The heart reveals aromatic Lavender and Black Pepper, creating a sophisticated depth. The base of Sandalwood, Vetiver, and Ambergris provides a rich, masculine warmth that lingers on skin for hours. Ideal for the modern man who lives boldly and sets his own path. 100ml Eau de Toilette.',
                'price'    => 9800,
                'sale'     => 8500,
            ],
            [
                'name'     => 'Midnight Bloom Eau de Parfum',
                'cat'      => 'womens-perfume',
                'brand'    => 'charlotte-tilbury',
                'short'    => 'A captivating, mysterious floral-woody fragrance that blooms with opulent rose and lingers with a warm, sensual base.',
                'desc'     => 'Charlotte Tilbury Midnight Bloom is an enchanting, opulent fragrance inspired by a night garden in full bloom. The opening burst of fresh Bergamot and Raspberry leads to a rich heart of Damascus Rose, Jasmine, and Ylang Ylang. The sensual dry-down of Sandalwood, Patchouli, and Musk creates an alluring, long-lasting warmth. A fragrance for those who live boldly after dark. Elegant bottle with gold accents. 50ml Eau de Parfum.',
                'price'    => 16000,
                'sale'     => 13999,
                'featured' => true,
            ],
            [
                'name'     => 'Pour Homme Sport Eau de Toilette',
                'cat'      => 'mens-cologne',
                'brand'    => 'mac-cosmetics',
                'short'    => 'A fresh, aquatic masculine fragrance with energising citrus top notes and a clean, long-lasting dry-down.',
                'desc'     => 'A contemporary masculine fragrance that blends fresh, aquatic notes with warm, woody undertones for a modern, sophisticated scent. The fresh opening of Bergamot, Lemon, and Sea Accord creates an invigorating first impression. The heart of Lavender and Geranium adds a classic masculine refinement, while the base of Cedarwood, Vetiver, and Amber provides depth and longevity. Perfect for daily wear and suitable for office to evening. 100ml Eau de Toilette.',
                'price'    => 8500,
            ],
            [
                'name'     => 'Rose Elixir Luxe Body Mist',
                'cat'      => 'body-sprays',
                'brand'    => 'laneige',
                'short'    => 'A delicate, hydrating body mist infused with Bulgarian Rose water that leaves skin subtly fragrant and glowing.',
                'desc'     => 'Laneige Rose Elixir Luxe Body Mist is a lightweight, hydrating body spray that wraps your skin in the delicate scent of fresh Bulgarian Rose. The fine mist formula instantly hydrates and refreshes skin while leaving a soft, romantic fragrance. Infused with Rose Water and Hyaluronic Acid, it provides a subtle moisture boost with every spritz. The clean, floral scent lingers beautifully without being overwhelming. Layer with your favourite perfume for a longer-lasting scent effect.',
                'price'    => 3500,
                'sale'     => 2999,
            ],
            [
                'name'     => 'Citrus Bloom Fresh Body Mist',
                'cat'      => 'body-sprays',
                'brand'    => 'nykaa',
                'short'    => 'A light, uplifting body mist with citrus and white floral notes that keeps you feeling fresh all day.',
                'desc'     => 'Nykaa Citrus Bloom Fresh Body Mist is a refreshing, lightly scented body spray perfect for everyday use. Bright citrus top notes of Orange and Bergamot lift the spirits, while a heart of White Jasmine and Freesia adds a clean, floral elegance. The dry-down of White Musk and Light Woods gives a fresh, skin-like quality that lasts throughout the day. Free from harsh chemicals and safe for sensitive skin. Perfect for layering over or under your favourite perfume.',
                'price'    => 1800,
            ],
            [
                'name'     => 'Oud Malaki Concentrated Perfume Oil',
                'cat'      => 'womens-perfume',
                'brand'    => 'huda-beauty',
                'short'    => 'A rich, opulent concentrated perfume oil with luxurious Oud, Rose, and Amber for a long-lasting Middle Eastern-inspired scent.',
                'desc'     => 'A richly concentrated perfume oil inspired by the opulence of Middle Eastern fragrance traditions. Pure, precious Oud from Assam is the star of this composition, blended with Damascus Rose Absolute, Saffron, and warm Amber. The concentrated oil formula means a tiny amount delivers hours of intense, evolving fragrance that is uniquely personal on each wearer\'s skin. Roll on pulse points for a deep, intimate scent experience. Free from alcohol. 10ml roller bottle.',
                'price'    => 6500,
                'featured' => true,
            ],
            [
                'name'     => 'Black Orchid Intense Pour Femme EDP',
                'cat'      => 'womens-perfume',
                'brand'    => 'charlotte-tilbury',
                'short'    => 'A deeply sensual, opulent fragrance with dark florals, rich spices, and a warm, lingering base of patchouli and sandalwood.',
                'desc'     => 'A bold, mysterious, and deeply feminine fragrance that makes an unforgettable first impression. Dark, velvety Black Orchid is the centrepiece of this composition, surrounded by Spiced Plum, Black Pepper, and Bitter Chocolate for an intoxicating depth. The warm dry-down of Black Patchouli, Sandalwood, and Vanilla creates a rich, lingering trail that evolves beautifully on skin. A fragrance for the confident, bold woman who leaves a lasting impression. 75ml Eau de Parfum.',
                'price'    => 14500,
                'sale'     => 12800,
            ],
            [
                'name'     => 'Blue Seduction Pour Homme EDT',
                'cat'      => 'mens-cologne',
                'brand'    => 'mac-cosmetics',
                'short'    => 'A seductive, woody-aromatic fragrance with a cool aquatic opening that transitions to warm, sensual woods.',
                'desc'     => 'A seductive and sophisticated masculine fragrance that opens with a cool, aquatic freshness before revealing a complex heart of aromatic herbs and spices. Top notes of Bergamot, Mandarin, and Sea Breeze create an invigorating opening. The heart of Lavender, Cardamom, and Black Pepper adds intrigue and warmth. The base of Cedarwood, Vetiver, and Sandalwood provides a long-lasting, sensual foundation. Modern and versatile, suitable for all occasions. 100ml Eau de Toilette.',
                'price'    => 7800,
                'sale'     => 6999,
            ],

            /* ═══════════════ BODY CARE ═══════════════ */

            [
                'name'     => 'Hydro Boost Body Gel Cream Moisturizer',
                'cat'      => 'body-lotions',
                'brand'    => 'neutrogena',
                'short'    => 'Lightweight, non-greasy body moisturizer with hyaluronic acid that absorbs instantly to deliver 48-hour hydration.',
                'desc'     => 'Neutrogena Hydro Boost Body Gel Cream is a lightweight body moisturizer that absorbs quickly and delivers 48-hour hydration. The unique water-gel formula, powered by hyaluronic acid, creates a moisture reservoir in the skin that replenishes moisture throughout the day. Non-greasy, fast-absorbing formula that won\'t clog pores. Clinically proven to hydrate better than a regular body lotion. Fragrance-free and suitable for all skin types. Can be used morning and night.',
                'price'    => 1800,
                'sale'     => 1499,
                'featured' => true,
            ],
            [
                'name'     => 'Norwegian Formula Concentrated Hand Cream',
                'cat'      => 'hand-foot-care',
                'brand'    => 'neutrogena',
                'short'    => 'The iconic concentrated hand cream that provides immediate and lasting relief for extremely dry, cracked hands.',
                'desc'     => 'Neutrogena Norwegian Formula Concentrated Hand Cream is a dermatologist-developed formula that provides immediate and lasting relief for extremely dry, damaged hands. The glycerin-rich formula creates a protective moisture barrier that heals and soothes cracked, rough skin with just one application. A little goes a long way — the concentrated formula means you only need a small amount. Fragrance-free, non-greasy, and absorbs quickly. Clinically proven to provide relief for dry skin.',
                'price'    => 1200,
            ],
            [
                'name'     => 'Ultra Moisturising Body Wash',
                'cat'      => 'bath-shower',
                'brand'    => 'cetaphil',
                'short'    => 'Gentle, soap-free body wash that cleans and moisturises in one step, leaving skin soft and comfortable after every shower.',
                'desc'     => 'Cetaphil Ultra Moisturising Body Wash is a gentle, soap-free formula that cleanses and moisturises skin in one easy step. The mild, fragrance-free formula is specially designed for dry to very dry skin types and is gentle enough for daily use. Enriched with Vitamin B5, Vitamin E, and Sweet Almond Oil, it replenishes and locks in moisture while gently removing dirt and impurities. Hypoallergenic and non-comedogenic. Dermatologist recommended and suitable for sensitive skin.',
                'price'    => 1500,
            ],
            [
                'name'     => 'Coffee & Coconut Body Scrub',
                'cat'      => 'body-scrubs',
                'brand'    => 'nykaa',
                'short'    => 'Energising coffee scrub with coconut oil that exfoliates dead skin cells and deeply moisturises for smooth, glowing skin.',
                'desc'     => 'Nykaa Naturals Coffee & Coconut Body Scrub is a natural, aromatic body scrub that energises your skin and senses. Finely ground Arabica coffee granules gently buff away dead skin cells, while cold-pressed Coconut Oil and Shea Butter deeply moisturise, leaving skin incredibly smooth and radiant. The natural caffeine in coffee helps improve blood circulation and can reduce the appearance of cellulite with regular use. Rinse-off formula, use 2-3 times per week in the shower.',
                'price'    => 1800,
                'sale'     => 1499,
                'featured' => true,
            ],
            [
                'name'     => 'Glow Recipe Watermelon Glow Body Lotion',
                'cat'      => 'body-lotions',
                'brand'    => 'nykaa',
                'short'    => 'A lightweight, fast-absorbing body lotion with watermelon extract and AHA that brightens and softens skin for a healthy glow.',
                'desc'     => 'A refreshing, brightening body lotion inspired by the glow-boosting powers of watermelon. Watermelon Extract provides antioxidant protection while soothing and hydrating skin. A blend of Hyaluronic Acid and Glycerin plumps and moisturises, while a gentle AHA complex encourages cell turnover for a visibly brighter, more even skin tone. The lightweight, gel-lotion formula absorbs immediately without stickiness. Use daily after showering for luminous, healthy-looking skin.',
                'price'    => 2800,
                'sale'     => 2399,
            ],
            [
                'name'     => 'Brightening Shower Milk Body Wash',
                'cat'      => 'bath-shower',
                'brand'    => 'laneige',
                'short'    => 'A luxurious shower milk that gently cleanses while brightening and softening skin for a radiant, glowing complexion.',
                'desc'     => 'Laneige Brightening Shower Milk is a creamy, nourishing body wash formulated with pure milk proteins and Vitamin C derivatives. The rich lather gently cleanses while brightening uneven skin tone and softening rough texture. The formula is enriched with a Moisture Wrap complex that forms an invisible barrier on the skin to lock in moisture long after your shower. Leaves skin feeling clean, bright, and irresistibly soft. Suitable for all skin types.',
                'price'    => 2500,
            ],
            [
                'name'     => 'Rose Sugar Body Scrub Exfoliator',
                'cat'      => 'body-scrubs',
                'brand'    => 'nykaa',
                'short'    => 'A luxurious sugar scrub with rose extract that gently exfoliates and deeply nourishes skin for a satin-smooth finish.',
                'desc'     => 'Nykaa Naturals Rose Sugar Body Scrub is a gentle yet effective exfoliating treatment that uses fine sugar crystals to buff away dullness and rough texture. Bulgarian Rose Extract and Rose Hip Oil provide antioxidant protection and deep nourishment, while Sweet Almond Oil and Jojoba Beads condition and soften skin. The delicate, romantic rose fragrance makes each use a spa-like experience. Rinse-off formula, suitable for all skin types. Use 2-3 times per week.',
                'price'    => 2200,
                'sale'     => 1899,
            ],
            [
                'name'     => 'Intensive Foot Cream Heel Repair',
                'cat'      => 'hand-foot-care',
                'brand'    => 'neutrogena',
                'short'    => 'Highly concentrated foot cream with glycerin that heals cracked heels and extremely dry feet overnight.',
                'desc'     => 'Neutrogena Norwegian Formula Intensive Foot Cream is the ultimate treatment for extremely dry, cracked heels and rough foot skin. The concentrated glycerin formula penetrates deeply to heal even severely dry skin and provides long-lasting moisture. Clinically proven to heal cracked heels with regular use. Apply generously to feet before bed and wear cotton socks overnight for best results. The formula is fragrance-free, non-greasy, and suitable for diabetic skin. Dermatologist recommended.',
                'price'    => 980,
            ],
            [
                'name'     => 'Intense Moisture 10 Oil in Cream Body Lotion',
                'cat'      => 'body-lotions',
                'brand'    => 'laneige',
                'short'    => 'A rich, oil-in-cream body lotion with 10 botanical oils that provides intense, all-day moisture for dry and very dry skin.',
                'desc'     => 'Laneige Intense Moisture 10 Oil in Cream is a richly nourishing body lotion formulated with a blend of 10 premium botanical oils including Argan, Jojoba, and Rose Hip oils. This innovative oil-in-cream formula melts into skin on contact, providing immediate comfort to dry, tight skin. The formula creates a lasting moisture barrier that locks in hydration for up to 24 hours. Skin feels immediately plump, soft, and supple. Subtle, elegant fragrance. Suitable for very dry skin.',
                'price'    => 4200,
                'sale'     => 3599,
                'featured' => true,
            ],
            [
                'name'     => 'Nourishing Body Butter Cream',
                'cat'      => 'body-lotions',
                'brand'    => 'cetaphil',
                'short'    => 'A thick, rich body butter that intensely nourishes and repairs very dry skin, leaving it silky-smooth and protected all day.',
                'desc'     => 'Cetaphil Nourishing Body Butter is a rich, concentrated moisturiser specially formulated for very dry, rough skin. The deeply nourishing formula contains Shea Butter, Sunflower Oil, and Vitamin E to repair the skin\'s natural moisture barrier and restore softness. The thicker consistency provides intense moisturisation that lasts all day, even in harsh weather conditions. Non-greasy once absorbed, this fragrance-free formula is gentle enough for sensitive skin and suitable for the whole family.',
                'price'    => 2200,
            ],

            /* ═══════════════ NAIL CARE ═══════════════ */

            [
                'name'     => 'Super Stay 7 Day Gel Nail Color',
                'cat'      => 'nail-polish',
                'brand'    => 'maybelline',
                'short'    => 'Long-wearing gel-like nail polish that delivers up to 7 days of chip-resistant colour and high shine, no UV lamp needed.',
                'desc'     => 'Maybelline Super Stay 7 Day Gel Nail Color gives you brilliant, chip-resistant colour for up to 7 days without a UV lamp or base coat. The built-in base coat ensures quick, even application, while the gel formula provides high-gloss shine and rich colour payoff. The formula is strengthened with an anti-chip top coat that seals in colour and prevents fading. Available in 40+ shades. Removes easily with regular nail polish remover. No salon needed for a professional gel look.',
                'price'    => 850,
                'featured' => true,
            ],
            [
                'name'     => 'Classic Nude Nail Polish Collection',
                'cat'      => 'nail-polish',
                'brand'    => 'nykaa',
                'short'    => 'A curated collection of 6 perfect nude nail polishes ranging from sheer pink to deep caramel to flatter every skin tone.',
                'desc'     => 'Nykaa Cosmetics Classic Nude Nail Polish Collection brings together the most universally flattering nude tones in one beautiful set. Each shade is crafted with a rich, pigmented formula that delivers full coverage in just 2 coats. The long-wearing formula is chip-resistant and provides up to 5 days of wear. Available as individual shades or a set, these nudes are the perfect base for nail art or a sophisticated standalone look. Free from Formaldehyde, DBP, and Toluene.',
                'price'    => 650,
            ],
            [
                'name'     => 'Pro Longwear Nail Colour',
                'cat'      => 'nail-polish',
                'brand'    => 'mac-cosmetics',
                'short'    => 'Professional-grade nail lacquer with rich, true colour that wears for up to 10 days without chipping or fading.',
                'desc'     => 'MAC Pro Longwear Nail Colour delivers richly pigmented, chip-resistant colour that lasts for up to 10 days. The professional formula uses advanced polymer technology to bond colour to the nail for extended wear. The wide brush allows for quick, even application in 2-3 strokes per nail. Long-wearing, high-gloss finish that resists chipping and fading. Available in 50+ shades from classic neutrals to bold statement colours. Suitable for use with or without a base and top coat.',
                'price'    => 2200,
                'sale'     => 1899,
            ],
            [
                'name'     => 'Cuticle Revitalising Oil Pen',
                'cat'      => 'nail-treatments',
                'brand'    => 'nykaa',
                'short'    => 'A nourishing cuticle oil pen enriched with Jojoba and Vitamin E that softens cuticles and promotes healthy nail growth.',
                'desc'     => 'Nykaa Cuticle Revitalising Oil Pen is a convenient, mess-free way to nourish and care for your cuticles. The precision twist pen delivers the perfect amount of oil directly to the cuticle area. Enriched with Jojoba Oil, Vitamin E, and Sweet Almond Oil, it deeply moisturises and softens hard, overgrown cuticles while promoting healthy nail growth. The refreshing Lavender and Lemon fragrance makes each application a treat. Use daily for best results. Suitable for all nail types.',
                'price'    => 580,
            ],
            [
                'name'     => 'Nail Strengthener Base Coat Treatment',
                'cat'      => 'nail-treatments',
                'brand'    => 'maybelline',
                'short'    => 'A hardening base coat that strengthens weak, brittle nails with every use while providing a smooth base for nail colour.',
                'desc'     => 'Maybelline Nail Strengthener is a powerful base coat treatment that hardens and fortifies weak, brittle, or peeling nails. The formula contains calcium and nylon microspheres that fill in ridges and imperfections for a perfectly smooth nail surface. With regular use, nails become noticeably stronger and more resistant to breakage. Apply as a base coat before nail colour, or use alone for a protective clear coat. Can also be applied to bare nails as a strengthening treatment without polish.',
                'price'    => 780,
            ],
            [
                'name'     => 'Nail Art Striping Brush & Dotting Tool Set',
                'cat'      => 'nail-art',
                'brand'    => 'nykaa',
                'short'    => 'A professional nail art brush set with fine liner brushes and dotting tools for creating intricate nail art designs.',
                'desc'     => 'Nykaa Nail Art Striping Brush & Dotting Tool Set is a complete nail art toolkit for creating salon-quality designs at home. The set includes ultra-thin striping brushes for fine lines and intricate details, fan brushes for gradient effects, and double-ended dotting tools for perfect dots and flowers. The brushes are made with premium synthetic fibres that hold their shape and deliver precise, controlled application. Suitable for use with any nail polish or acrylic paint.',
                'price'    => 1200,
            ],
            [
                'name'     => 'Glitter Vinyl Nail Polish Set',
                'cat'      => 'nail-art',
                'brand'    => 'nyx',
                'short'    => 'A show-stopping set of glitter and metallic nail polishes that create dazzling, eye-catching nail looks for every occasion.',
                'desc'     => 'NYX Professional Makeup Glitter Vinyl Nail Polish Set includes 6 richly pigmented shades with a unique vinyl-like finish that captures and reflects light for a dazzling sparkle. Each polish is packed with fine and chunky glitter particles in a long-wearing formula that resists chipping. The vibrant, high-impact colours can be worn alone or layered over a base colour for a customised, multidimensional look. Perfect for parties, festivals, and special occasions. Cruelty-free formula.',
                'price'    => 950,
            ],
            [
                'name'     => 'Smooth Matte Top Coat Nail Finisher',
                'cat'      => 'nail-polish',
                'brand'    => 'nyx',
                'short'    => 'A fast-drying matte top coat that transforms any nail colour into a trendy, velvety matte finish in seconds.',
                'desc'     => 'NYX Professional Makeup Smooth Matte Top Coat instantly converts any glossy nail polish into a sophisticated, velvety matte finish. The fast-drying formula applies over any nail colour and dries in under a minute to a smooth, uniform matte. Extends the wear of your nail colour while adding a modern, fashionable finish. The formula also helps prevent chipping and extends the life of your manicure. Cruelty-free and vegan formula. Suitable for natural and artificial nails.',
                'price'    => 1100,
            ],
            [
                'name'     => 'True Wear Nail Enamel Classic Red',
                'cat'      => 'nail-polish',
                'brand'    => 'lakme',
                'short'    => 'A rich, vibrant nail enamel with a gel-like shine that lasts up to 7 days for a perfect, salon-finish manicure.',
                'desc'     => 'Lakme True Wear Nail Enamel in Classic Red is a richly pigmented nail lacquer that delivers full coverage in just one coat. The long-wearing formula provides a high-gloss, gel-like shine that resists chipping and fading for up to 7 days. The wide, flat brush ensures quick, even application and salon-like results at home. Free from Formaldehyde, Toluene, and DBP. Available in 50+ shades including classics, neons, metallics, and pastels. Suitable for all nail types.',
                'price'    => 650,
            ],
            [
                'name'     => 'Crystal Clear Base & Top Coat',
                'cat'      => 'nail-treatments',
                'brand'    => 'lakme',
                'short'    => 'A dual-use clear nail treatment that protects bare nails as a base coat and extends colour wear as a high-shine top coat.',
                'desc'     => 'Lakme Crystal Clear is a versatile, multi-purpose nail treatment that works both as a base coat and a top coat. As a base coat, it creates a smooth canvas, fills in ridges, and prevents staining from dark nail colours. As a top coat, it seals in colour, adds a brilliant high-shine finish, and extends the wear of your manicure. The fast-drying formula hardens in seconds. Free from harsh chemicals. Suitable for natural and acrylic nails.',
                'price'    => 650,
            ],

            /* ═══════════════ TOOLS & BRUSHES ═══════════════ */

            [
                'name'     => 'Pro Brush Set 15-Piece Collection',
                'cat'      => 'makeup-brushes',
                'brand'    => 'mac-cosmetics',
                'short'    => 'A comprehensive professional-grade 15-piece brush collection for flawless face, eye, and contour application.',
                'desc'     => 'MAC Pro Brush Set 15-Piece Collection includes all the professional tools needed for a complete makeup look. The set features face brushes for powder, blush, contour, and foundation application; eye brushes for eyeshadow, blending, and liner; and specialty brushes for highlight and brow grooming. Each brush is crafted with ultra-soft, hand-cut synthetic or natural fibres that hold their shape and provide precise, controlled application. Comes in an elegant roll-up brush case.',
                'price'    => 8500,
                'sale'     => 7200,
                'featured' => true,
            ],
            [
                'name'     => 'Full Coverage Foundation Brush #190',
                'cat'      => 'makeup-brushes',
                'brand'    => 'mac-cosmetics',
                'short'    => 'The iconic MAC #190 flat foundation brush for seamlessly blending liquid and cream foundations to a flawless finish.',
                'desc'     => 'The MAC #190 Foundation Brush is the professional\'s choice for flawless liquid and cream foundation application. The flat, tapered tip allows for targeted application and the dense, tightly-packed bristles ensure seamless blending for full, buildable coverage. The ergonomic handle provides control and precision. Work in circular and sweeping motions for a natural, skin-like finish. Synthetic bristles are gentle on sensitive skin and easy to clean. A must-have in every makeup kit.',
                'price'    => 3200,
            ],
            [
                'name'     => 'Eye Brush Collection 5-Piece Set',
                'cat'      => 'makeup-brushes',
                'brand'    => 'huda-beauty',
                'short'    => 'A curated set of 5 essential eye brushes for blending, defining, and perfecting eyeshadow looks with precision.',
                'desc'     => 'Huda Beauty Eye Brush Collection contains 5 essential brushes for creating any eye look. The set includes a flat shader brush for packing colour on the lid, a blending brush for seamless transition shades, a pencil brush for detailed crease work, a flat liner brush for precise application, and a spoolie brush for grooming brows and lashes. All brushes feature ultra-soft, vegan bristles that pick up product efficiently and blend effortlessly. Suitable for powder, cream, and liquid formulas.',
                'price'    => 5500,
                'sale'     => 4800,
                'featured' => true,
            ],
            [
                'name'     => 'Powder & Blush Fan Brush',
                'cat'      => 'makeup-brushes',
                'brand'    => 'nyx',
                'short'    => 'A soft, fluffy fan brush for dusting on highlighter, powder, and setting sprays with a light, diffused finish.',
                'desc'     => 'NYX Professional Makeup Fan Brush is a versatile tool perfect for applying powder, highlighter, and blush with a soft, diffused effect. The fan-shaped head allows for a light, airy application that mimics the look of naturally flushed skin. Use it to sweep powder across the face for a soft-focus finish, to apply highlighter to the high points of the face, or to remove excess eyeshadow fallout. The cruelty-free, vegan bristles are ultra-soft and gentle on the skin.',
                'price'    => 1800,
            ],
            [
                'name'     => 'Jade Roller & Gua Sha Facial Massage Set',
                'cat'      => 'skincare-devices',
                'brand'    => 'nykaa',
                'short'    => 'An authentic jade stone facial massage duo that depuffs, boosts circulation, and helps skincare products absorb better.',
                'desc'     => 'Nykaa Naturals Jade Roller & Gua Sha Set features two traditional Chinese facial massage tools made from genuine, cool-to-touch jade stone. The dual-headed roller massages the face to reduce puffiness, improve lymphatic drainage, and boost blood circulation for a natural glow. The Gua Sha stone is used to sculpt and contour the face, reduce muscle tension, and improve the absorption of serums and moisturisers. Use with your favourite facial oil or serum for best results. Includes a velvet storage pouch.',
                'price'    => 2800,
                'sale'     => 2299,
            ],
            [
                'name'     => 'Silicone Sonic Facial Cleansing Brush',
                'cat'      => 'skincare-devices',
                'brand'    => 'nykaa',
                'short'    => 'A waterproof silicone cleansing brush with 6 vibration modes that removes 99% more makeup and impurities than hands alone.',
                'desc'     => 'Nykaa Silicone Sonic Facial Cleansing Brush uses gentle sonic vibrations to deeply cleanse pores and remove makeup, dirt, and impurities more effectively than manual cleansing. The ultra-hygienic, non-porous silicone bristles are 35 times more hygienic than nylon bristle brushes and won\'t harbour bacteria. Features 6 vibration intensity levels and 3 modes for customised cleansing. Waterproof design for use in the shower. USB rechargeable. Suitable for all skin types including sensitive skin.',
                'price'    => 1500,
            ],
            [
                'name'     => 'Ceramic Infrared Hair Straightener 230°C',
                'cat'      => 'hair-tools',
                'brand'    => 'loreal-paris',
                'short'    => 'Professional-grade ceramic straightening iron with infrared heat technology that straightens and protects hair in one pass.',
                'desc'     => 'L\'Oréal Steampod Professional Ceramic Hair Straightener uses Infrared Heat Technology to deliver heat from within the hair shaft, straightening from the inside out with less surface damage. Ceramic plates coated with a non-stick, anti-frizz treatment ensure silky-smooth results in one pass. Adjustable temperature from 150-230°C to suit all hair types. Heats up in just 10 seconds. Auto-temperature regulation ensures optimal results. 3-metre professional cord with 360-degree swivel.',
                'price'    => 6500,
                'sale'     => 5499,
                'featured' => true,
            ],
            [
                'name'     => 'Professional Ionic Blow Dryer 2200W',
                'cat'      => 'hair-tools',
                'brand'    => 'loreal-paris',
                'short'    => 'A powerful 2200W ionic hair dryer that dries hair faster while reducing frizz for a smooth, shiny, salon-finish blowout.',
                'desc'     => 'L\'Oréal Professional Ionic Blow Dryer delivers salon-quality results at home. The powerful 2200W AC motor dries hair 40% faster than conventional dryers. Ionic technology neutralises positive charges in wet hair to eliminate frizz and enhance shine. The Ceramic & Tourmaline-infused grille distributes heat evenly to prevent hot spots and heat damage. Features 3 heat settings, 2 speed settings, and a cool shot button. Includes a concentrator and diffuser attachment. Foldable handle.',
                'price'    => 8800,
                'sale'     => 7499,
            ],
            [
                'name'     => 'Curling Wand 25mm Ceramic Barrel',
                'cat'      => 'hair-tools',
                'brand'    => 'loreal-paris',
                'short'    => 'A professional 25mm ceramic curling wand that creates perfect, long-lasting curls and waves with less heat damage.',
                'desc'     => 'L\'Oréal Professional Curling Wand features a 25mm ceramic-coated barrel that creates beautiful, uniform curls and waves. The ceramic barrel provides even heat distribution for consistent results and reduces frizz for shiny, smooth curls. Heats up to 220°C in 30 seconds. Advanced temperature control prevents overheating. The ergonomic grip and cool tip allow for safe, comfortable styling. Includes a heat-resistant glove and a sectioning clip. Auto-shutoff after 60 minutes for safety.',
                'price'    => 4200,
                'sale'     => 3599,
            ],

        ];
    }
}
