<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'    => 0,
            'total_revenue'   => 0,
            'total_customers' => 0,
            'total_products'  => 0,
            'out_of_stock'    => 0,
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
