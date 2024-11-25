<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // Ambil parameter pencarian dan filter
        $searchTerm = $request->input('search');
        $category = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // Buat query dasar untuk memfilter produk
        $query = Product::query();

        // Filter berdasarkan kata kunci pencarian (hanya nama produk)
        if ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        // Filter berdasarkan kategori
        if ($category) {
            $query->where('category_id', $category);
        }

        // Filter berdasarkan rentang harga
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        // Ambil produk yang sesuai dengan filter dan pagination
        $products = $query->paginate(10);

        // Ambil kategori untuk dropdown di halaman pencarian
        $categories = Category::all();

        // Return hasil pencarian ke view
        return view('products.search_results', compact('products', 'categories'));
    }
}
