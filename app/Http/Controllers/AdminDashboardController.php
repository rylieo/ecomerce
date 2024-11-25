<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
{
    // Ambil status, date, dan customer name dari permintaan
    $status = $request->get('status');
    $date = $request->get('date');
    $customerName = $request->get('customer_name');

    // Mengambil order berdasarkan status, tanggal, dan customer name jika ada
    $orders = Order::with('orderItems.product', 'user')
                ->when($status, function($query, $status) {
                    return $query->where('status', $status);
                })
                ->when($date, function($query) use ($date) {
                    return $query->whereDate('created_at', $date);
                })
                ->when($customerName, function($query, $customerName) {
                    return $query->whereHas('user', function($q) use ($customerName) {
                        $q->where('name', 'like', "%{$customerName}%");
                    });
                })
                ->orderBy('created_at', 'desc')
                ->get();

    return view('admin.dashboard', compact('orders'));
}

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:proses,dikemas,dikirim,selesai',
        ]);

        $order->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Order status updated successfully.');
    }

    public function edit()
    {
        return view('admin.editTop');
    }

    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'media' => 'required|file|mimes:mp4,jpg,jpeg,png,gif|max:20480', // Max file size: 20MB
        ]);

        // Ambil file yang di-upload
        $media = $request->file('media');

        // Simpan file ke public folder
        $filePath = $media->store('media', 'public');

        // Tentukan tipe media (video atau gambar)
        $mediaType = $media->getMimeType();
        if (strpos($mediaType, 'video') !== false) {
            $type = 'video';
        } else {
            $type = 'image';
        }

        // Simpan URL media dan tipe media ke session
        session([
            'media_url' => asset('storage/' . $filePath),
            'media_type' => $type,
        ]);

        return view('component.Top', [
            'media_url' => asset('storage/' . $filePath),
            'media_type' => $type
        ])->with('success', 'Media updated successfully!');
    }

    public function bulkUpdateOrderStatus(Request $request)
{
    $request->validate([
        'order_ids' => 'required|array',
        'order_ids.*' => 'exists:orders,id', // Validate that all IDs exist in the orders table
        'bulk_status' => 'required|in:proses,dikemas,dikirim,selesai',
    ]);

    // Update the status for all selected orders
    Order::whereIn('id', $request->order_ids)->update(['status' => $request->bulk_status]);

    return redirect()->route('admin.dashboard')->with('success', 'Selected order statuses updated successfully.');
}

}
