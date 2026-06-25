<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $cat = $request->query('cat', 'all');

        $titles = [
            'makeup'    => 'Makeup',
            'skincare'  => 'Skincare',
            'haircare'  => 'Haircare',
            'fragrance' => 'Fragrances',
            'bath-body' => 'Bath & Body',
            'tools'     => 'Tools',
            'offers'    => 'Offers',
            'all'       => 'Shop All',
        ];

        $descriptions = [
            'makeup'    => 'Discover our curated collection of premium makeup — from flawless foundations to bold lipsticks.',
            'skincare'  => 'Nourish and protect your skin with our range of premium skincare products.',
            'haircare'  => 'Transform your hair with salon-quality products from leading brands.',
            'fragrance' => 'Explore our collection of luxury fragrances for every mood and occasion.',
            'bath-body' => 'Indulge in luxurious bath and body essentials for a spa-like experience.',
            'tools'     => 'Professional beauty tools to perfect your look every day.',
            'offers'    => 'Exclusive deals and flash sales on your favourite beauty products.',
            'all'       => 'Discover our full collection of premium beauty products.',
        ];

        return view('category', [
            'pageTitle'       => $titles[$cat] ?? 'Shop',
            'pageDescription' => $descriptions[$cat] ?? '',
            'currentCat'      => $cat,
            'products'        => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12),
        ]);
    }
}
