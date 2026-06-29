<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            ['code' => 'BHARKA10',  'type' => 'percent', 'value' => 10, 'min_order' => 0,    'active' => true],
            ['code' => 'BEAUTY20',  'type' => 'percent', 'value' => 20, 'min_order' => 2000, 'active' => true],
            ['code' => 'WELCOME150','type' => 'fixed',   'value' => 150,'min_order' => 1000, 'active' => true],
            ['code' => 'SAVE500',   'type' => 'fixed',   'value' => 500,'min_order' => 3000, 'active' => true],
        ];

        foreach ($coupons as $data) {
            Coupon::updateOrCreate(['code' => $data['code']], $data);
        }
    }
}
