<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ContactInfo;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {

        // Ambil produk yang baru diluncurkan (dalam 15 hari)
        $products = Product::with('category')
            ->where('launch_date', '>=', now()->subDays(15)) // Produk baru dalam 15 hari
            ->get();

        return view('products.index', compact('products'));
    }

    public function userIndex()
    {
        $products = Product::all();
        $contacts = ContactInfo::first();

        return view('component.products', compact('products', 'contacts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle photo upload
        $photoPath = $request->file('photo')->store('photos', 'public');

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'price' => $request->price,
            'photo' => $photoPath,
            'launch_date' => now(), // Menyimpan tanggal peluncuran
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Check if a new photo is uploaded
        if ($request->hasFile('photo')) {
            // Store the new photo on the public disk
            $photoPath = $request->file('photo')->store('photos', 'public');

            // Delete the old photo if exists
            if ($product->photo) {
                Storage::disk('public')->delete($product->photo);
            }

            // Update the photo path
            $product->photo = $photoPath;
        }

        // Update the product fields
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'price' => $request->price,
            'photo' => $product->photo,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Mencari produk berdasarkan nama
        $products = Product::where('name', 'LIKE', "%$query%")->get();

        // Jika tidak ada produk ditemukan, tetap kirimkan variabel $products sebagai koleksi kosong
        if ($products->isEmpty()) {
            $message = 'Produk tidak ditemukan untuk pencarian Anda.';
            return view('products.search_results', compact('products', 'message'));
        }

        // Jika produk ditemukan, kembalikan hasil pencarian
        $message = null; // Pesan kosong ketika produk ditemukan
        return view('products.search_results', compact('products', 'message'));
    }

    public function destroy(Product $product)
    {
        if ($product->photo) {
            Storage::disk('public')->delete($product->photo);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function show($id)
    {
        // Use findOrFail to handle if product is not found
        $product = Product::findOrFail($id);
        $contacts = ContactInfo::first();

        // Eager load related products to avoid N+1 issue
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->get();

        return view('customer.products.show', compact('product', 'relatedProducts', 'contacts'));
    }
    public function newProducts()
    {
        // Ambil produk yang baru diluncurkan (dalam 15 hari)
        $products = Product::with('category')
            ->where('created_at', '>=', now()->subDays(15))
            ->get();
            $contacts = ContactInfo::first();


        return view('products.new', compact('products', 'contacts'));
    }


}
