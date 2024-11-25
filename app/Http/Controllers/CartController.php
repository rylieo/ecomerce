<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\ContactInfo;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
{
    $carts = Cart::with('product')->where('user_id', Auth::id())->get();
    $contacts = ContactInfo::first();
    $total = $carts->isEmpty() ? 0 : $carts->sum(function ($cart) {
        return $cart->product->price * $cart->quantity;
    });

    $itemCount = $carts->isEmpty() ? 0 : $carts->sum('quantity',);

    $isEmpty = $carts->isEmpty(); // Tambahkan ini untuk mengecek apakah keranjang kosong

    return view('customer.cart.index', compact('carts', 'total', 'itemCount', 'isEmpty', 'contacts')); // Sertakan $isEmpty
}


    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $request->input('product_id'))
                    ->first();

        if ($cart) {
            $cart->quantity += $request->input('quantity');
        } else {
            $cart = new Cart();
            $cart->user_id = Auth::id();
            $cart->product_id = $request->input('product_id');
            $cart->quantity = $request->input('quantity');
        }

        $cart->save();

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }

    public function increaseQuantity($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->quantity += 1;
        $cart->save();

        return redirect()->route('cart.index')->with('success', 'Quantity increased successfully!');
    }

    public function decreaseQuantity($id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart->quantity > 1) {
            $cart->quantity -= 1;
            $cart->save();
            return redirect()->route('cart.index')->with('success', 'Quantity decreased successfully!');
        } else {
            return redirect()->route('cart.index')->with('error', 'Quantity cannot be less than 1.');
        }
    }

    public function removeProduct($id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }

    public function remove($id)
    {
        Cart::where('id', $id)->delete();

        return back()->with('success', 'Item has been removed from cart.');
    }

    public function summary(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);

        $carts = Cart::with('product')->where('user_id', Auth::id())->get();

        $total = 0;
        $itemCount = count($selectedItems);

        if ($itemCount === 0) {
            return view('customer.cart.index', compact('carts', 'total', 'itemCount'))
                ->with('warning', 'No items selected.');
        }

        foreach ($selectedItems as $itemId) {
            $cartItem = $carts->firstWhere('id', $itemId);

            if ($cartItem) {
                $total += $cartItem->product->price * $cartItem->quantity;
            }
        }

        return view('customer.cart.index', compact('carts', 'total', 'itemCount'));
    }
}
