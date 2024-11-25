<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Media;
use App\Models\ContactInfo;
use Illuminate\Http\Request;


class WelcomeController extends Controller
{
    public function index()
    {
        // Ambil semua produk dan media dari database
        $mediaItems = Media::all();
        $products = Product::all();
        $contacts = ContactInfo::first();

        // Kirim variabel products dan mediaItems ke view
        return view('welcome', compact('products', 'mediaItems', 'contacts'));
    }
}
