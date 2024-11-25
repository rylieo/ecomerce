<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $selectedItems = $request->input('selected_items');

        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'Please select at least one item to checkout.');
        }

        $carts = Cart::whereIn('id', $selectedItems)->with('product')->get();
        $totalPrice = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });

        return view('customer.checkout.index', compact('carts', 'totalPrice'));
    }

    public function process(Request $request)
{
    $selectedItems = $request->input('selected_items');

    if (is_null($selectedItems) || !is_array($selectedItems) || empty($selectedItems)) {
        return redirect()->route('cart.index')->with('error', 'No items selected for checkout.');
    }

    $carts = Cart::whereIn('id', $selectedItems)->with('product')->get();

    // Generate order code
    $orderCode = strtoupper(uniqid('ORD'));

    // Ambil alamat utama atau alamat tambahan
    $shippingAddress = $request->input('shipping_address');
    $additionalAddresses = $request->input('additional_addresses');

    // Cek jika alamat utama kosong
    if (empty($shippingAddress)) {
        return redirect()->route('cart.index')->with('error', 'Shipping address is required.');
    }

    // Jika alamat tambahan dipilih, pastikan ada alamat yang diinput
    if ($request->input('shipping_address') === 'alamat_tambahan') {
        if (empty($additionalAddresses) || !isset($additionalAddresses[0]) || empty($additionalAddresses[0])) {
            return redirect()->route('cart.index')->with('error', 'Please enter a valid additional address.');
        }
        // Gunakan alamat tambahan yang diinput
        $shippingAddress = $additionalAddresses[0];
    }

    // Simpan order ke database
    $order = Order::create([
        'user_id' => Auth::id(),
        'order_code' => $orderCode,
        'shipping_address' => $shippingAddress,
        'payment_method' => $request->input('payment_method'),
        'status' => 'proses',
    ]);

    // Simpan alamat tambahan ke database jika ada
    if (!empty($additionalAddresses)) {
        foreach ($additionalAddresses as $additionalAddress) {
            if ($additionalAddress) {
                Address::create([
                    'user_id' => Auth::id(),
                    'address' => $additionalAddress,
                ]);
            }
        }
    }

    foreach ($carts as $cart) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $cart->product_id,
            'quantity' => $cart->quantity,
            'price' => $cart->product->price,
        ]);
    }

    // Kirim notifikasi ke Telegram
    $this->sendTelegramNotification($carts, $orderCode, $shippingAddress, $order->payment_method);

    // Hapus item dari keranjang yang telah dipesan
    Cart::whereIn('id', $selectedItems)->delete();

    return redirect()->route('order.message', ['orderCode' => $orderCode])
        ->with('success', 'Your order has been placed successfully!');
}

private function sendTelegramNotification($carts, $orderCode, $shippingAddress, $paymentMethod, $additionalAddress = null)
{
    $user = Auth::user();

    if ($carts->isEmpty()) {
        Log::error('No items in cart to send to Telegram.');
        return;
    }

    $totalPrice = $carts->sum(function ($cart) {
        return $cart->product->price * $cart->quantity;
    });

    $message = "Kode Pesanan: {$orderCode}\n";
    $message .= "Nama: {$user->name}\nEmail: {$user->email}\n";
    $message .= "Total: Rp " . number_format($totalPrice, 0, ',', '.') . "\n";
    $message .= "Shipping Address: {$shippingAddress}\n";

    // Jika ada alamat tambahan, masukkan ke dalam pesan
    if ($additionalAddress) {
        $message .= "Alamat Tambahan: {$additionalAddress}\n";
    }

    $message .= "Payment Method: {$paymentMethod}\n\n";
    $message .= "Pesanan:\n";

    foreach ($carts as $cart) {
        $product = $cart->product;

        if ($product->stock < $cart->quantity) {
            throw new \Exception("Stok untuk {$product->name} tidak mencukupi. Sisa stok: {$product->stock}.");
        }

        $message .= "{$product->name} - Jumlah: {$cart->quantity}, Harga Satuan: Rp " . number_format($product->price, 0, ',', '.') . "\n";

        $product->stock -= $cart->quantity;
        $product->save();
    }

    $message .= "\nTotal Harga: Rp " . number_format($totalPrice, 0, ',', '.');

    try {
        $client = new Client();
        $response = $client->post("https://api.telegram.org/bot" . "7671784889:AAGoCYC7edVOBnLOgI1n8rf-Tz7igaAyrRc" . "/sendMessage", [
            'json' => [
                'chat_id' => "5199082272",
                'text' => $message
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            throw new \Exception("Failed to send message. Status code: " . $response->getStatusCode());
        }
    } catch (\Exception $e) {
        Log::error('Telegram notification error: ' . $e->getMessage());
    }
}

}
