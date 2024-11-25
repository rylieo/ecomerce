<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function donutChartController()
    {
        $categories = Category::withCount(['products as total_orders' => function ($query) {
            $query->join('order_items', 'products.id', '=', 'order_items.product_id')
                ->selectRaw('sum(order_items.quantity) as total');
        }])->get();

        $categoryNames = $categories->pluck('name');
        $orderCounts = $categories->pluck('total_orders');

        // Data untuk produk yang terjual per hari
        $dailySales = DB::table('order_items')
            ->select(DB::raw('DATE(created_at) as sale_date'), DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('sale_date')
            ->orderBy('sale_date')
            ->get();

        $days = $dailySales->pluck('sale_date'); // Nama hari
        $productSoldCounts = $dailySales->pluck('total_sold'); // Jumlah produk yang terjual

        // Data untuk produk yang terjual per bulan
        $monthlySales = DB::table('order_items')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as sale_month'), DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('sale_month')
            ->orderBy('sale_month')
            ->get();

        $months = $monthlySales->pluck('sale_month'); // Nama bulan
        $monthlySoldCounts = $monthlySales->pluck('total_sold'); // Jumlah produk yang terjual per bulan

        // Data untuk produk yang terjual per tahun
        $yearlySales = DB::table('order_items')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y") as sale_year'), DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('sale_year')
            ->orderBy('sale_year')
            ->get();

        $years = $yearlySales->pluck('sale_year'); // Nama tahun
        $yearlySoldCounts = $yearlySales->pluck('total_sold'); // Jumlah produk yang terjual per tahun

        return view('admin.index', compact('categoryNames', 'orderCounts', 'categories', 'days', 'productSoldCounts', 'months', 'monthlySoldCounts', 'years', 'yearlySoldCounts'));
    }
}
