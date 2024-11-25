<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ContactInfo;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
{
    // Mengambil semua order milik user yang sedang login, diurutkan berdasarkan tanggal dibuat terbaru
    $orders = Order::where('user_id', Auth::id())
                   ->with('orderItems.product')
                   ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan tanggal dibuat terbaru
                   ->get();
                   $contacts = ContactInfo::first();


    return view('dashboard', compact('orders', 'contacts'));
}

}
