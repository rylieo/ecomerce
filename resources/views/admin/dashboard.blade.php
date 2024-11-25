@extends('layouts.sidebar')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Welcome to Order Table</h1>
    <p class="lead">Hello, {{ auth()->user()->name }}! Welcome to the admin area. You can manage your products, orders, and more from here.</p>

    <!-- Form Filter -->
    <form action="{{ route('admin.dashboard') }}" method="GET" class="mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <select name="status" class="form-select custom-select" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="dikemas" {{ request('status') == 'dikemas' ? 'selected' : '' }}>Dikemas</option>
                    <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="date" class="form-control custom-input" value="{{ request('date') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="customer_name" class="form-control custom-input" placeholder="Customer Name" value="{{ request('customer_name') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary d-flex align-items-center custom-btn">
                    <i class="fas fa-filter me-2"></i> Filter
                </button>
            </div>
        </div>
    </form>

    @if($orders->isEmpty())
        <div class="alert alert-info">No orders found.</div>
    @else
        <form action="{{ route('admin.bulkUpdateOrderStatus') }}" method="POST" class="mb-4">
            @csrf

            <!-- Input untuk update status berada di atas tabel -->
            <div class="mb-3">
                <select name="bulk_status" class="form-select custom-select" required>
                    <option value="">Select New Status</option>
                    <option value="proses">Proses</option>
                    <option value="dikemas">Dikemas</option>
                    <option value="dikirim">Dikirim</option>
                    <option value="selesai">Selesai</option>
                </select>
                <button type="submit" class="btn btn-primary mt-2 d-flex align-items-center custom-btn">
                    <i class="fas fa-sync-alt me-2"></i> Update Selected Orders
                </button>
            </div>

            <div class="table-responsive animate-table">
                <table class="table table-hover custom-table">
                    <thead class="table-header">
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Order Code</th>
                            <th>Customer Name</th>
                            <th>Total Items</th>
                            <th>Total Price</th>
                            <th>Shipping Address</th>
                            <th>Status</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td><input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="order-checkbox"></td>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->orderItems->sum('quantity') }}</td>
                                <td>
                                    Rp {{ number_format($order->orderItems->sum(function($item) {
                                        return $item->quantity * $item->price;
                                    }), 0, ',', '.') }}
                                </td>
                                <td>{{ $order->shipping_address }}</td>
                                <td>
                                    <select name="status[{{ $order->id }}]" class="form-select custom-select">
                                        <option value="proses" {{ $order->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="dikemas" {{ $order->status == 'dikemas' ? 'selected' : '' }}>Dikemas</option>
                                        <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                        <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const orderCheckboxes = document.querySelectorAll('.order-checkbox');

        selectAllCheckbox.addEventListener('change', function() {
            orderCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        const table = document.querySelector('.animate-table');
        table.classList.add('visible');
    });
</script>

<style>
/* Styling untuk form */
.custom-input, .custom-select {
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s ease;
}
.custom-input:focus, .custom-select:focus {
    border-color: #6c63ff;
    box-shadow: 0 2px 6px rgba(108, 99, 255, 0.3);
}

/* Styling tombol filter dan update */
.custom-btn {
    border-radius: 8px;
    background-color: #4e73df;
    color: white;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}
.custom-btn:hover {
    background-color: #2e59d9;
    transform: translateY(-2px);
}

/* Styling tabel */
.custom-table {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}
.table-header th {
    background-color: #5b6bff;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
}
.custom-table tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
    transition: all 0.2s ease;
}

/* Animasi fade-in */
.animate-table {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.5s ease, transform 0.5s ease;
}
.animate-table.visible {
    opacity: 1;
    transform: translateY(0);
}
</style>
@endsection
