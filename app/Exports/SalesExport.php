<?php

namespace App\Exports;

use App\Models\OrderItem;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalesExport implements FromView
{
    public function view(): View
    {
        $dailySales = OrderItem::selectRaw('DATE(created_at) as sale_date, SUM(quantity) as total_sold')
            ->groupBy('sale_date')
            ->orderBy('sale_date')
            ->get();

        $monthlySales = OrderItem::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as sale_month, SUM(quantity) as total_sold')
            ->groupBy('sale_month')
            ->orderBy('sale_month')
            ->get();

        $yearlySales = OrderItem::selectRaw('DATE_FORMAT(created_at, "%Y") as sale_year, SUM(quantity) as total_sold')
            ->groupBy('sale_year')
            ->orderBy('sale_year')
            ->get();

        return view('exports.sales', [
            'dailySales' => $dailySales,
            'monthlySales' => $monthlySales,
            'yearlySales' => $yearlySales,
        ]);
    }
}
