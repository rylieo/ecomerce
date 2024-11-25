@extends('layouts.app')

@section('content')
<main>
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <!-- Sidebar Settings -->
                <div class="settings-sidebar">
                    <h2>Pengaturan</h2>
                    <ul class="settings-menu">
                        <li>
                            <a href="{{ route('profile') }}">
                                <i class="fas fa-user-circle"></i> Profil
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fas fa-box"></i> Pesanan Saya
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('password.change.form') }}">
                                <i class="fas fa-lock"></i> Ubah Password
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                        if (confirm('Apakah Anda yakin ingin logout?')) {
                                            document.getElementById('logout-form').submit();
                                        }">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>

                <!-- Orders Section -->
                <div class="orders-section">
                    <h2>List Pesanan</h2>
                    @if($orders->isEmpty())
                        <p>Anda belum memiliki pesanan.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Kode Pesanan</th>
                                        <th scope="col">Total Item</th>
                                        <th scope="col">Total Harga</th>
                                        <th scope="col">Tanggal Pesanan</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_code }}</td>
                                        <td>{{ $order->orderItems->sum('quantity') }}</td>
                                        <td>Rp {{ number_format($order->orderItems->sum(function($item) {
                                                return $item->quantity * $item->price;
                                            }), 0, ',', '.') }}
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if($order->status == 'proses')
                                                <i class="fas fa-spinner fa-spin text-secondary"></i> <span class="badge badge-secondary">Proses</span>
                                            @elseif($order->status == 'dikemas')
                                                <i class="fas fa-box text-warning"></i> <span class="badge badge-warning">Dikemas</span>
                                            @elseif($order->status == 'dikirim')
                                                <i class="fas fa-shipping-fast text-success"></i> <span class="badge badge-success">Dikirim</span>
                                            @elseif($order->status == 'selesai')
                                                <i class="fas fa-check text-primary"></i> <span class="badge badge-primary">Selesai</span>
                                            @else
                                                <i class="fas fa-exclamation-circle text-danger"></i> <span class="badge badge-danger">Tidak Diketahui</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>

@push('styles')
<style>
    body {
        background-color: #f0f4f8; /* Warna latar belakang cerah */
        font-family: 'Poppins', sans-serif;
    }

    .profile-section {
        padding: 40px 0;
        margin-top: 110px; /* Margin top for navbar */
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .profile-container {
        display: flex;
        gap: 30px;
        flex-wrap: wrap; /* Items wrap on smaller screens */
    }

    .settings-sidebar {
        width: 100%;
        max-width: 300px;
        background: transparent;
        padding: 20px;
        border-radius: 15px; /* Rounded corners */
        margin-bottom: 40px;
        transition: transform 0.3s;
        padding-left: 120px;
        margin-top: 15px;
    }

    .settings-sidebar:hover {
        transform: translateY(-2px);
    }

    .settings-sidebar h2 {
        margin-top: 0;
        font-size: 24px;
        color: #333;
    }

    .settings-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .settings-menu li {
        margin-bottom: 15px;
    }

    .settings-menu li a {
        color: #555;
        text-decoration: none;
        font-size: 16px;
        padding: 10px 15px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: background 0.3s ease, color 0.3s ease;
    }

    .settings-menu li a:hover {
        background: rgba(100, 100, 100, 0.1);
        color: #007bff; /* Color on hover */
    }

    /* Tabel Pesanan */
    .table-hover tbody tr:hover {
        background-color: #f0f0f0;
    }

    .badge-secondary {
        background-color: #818181;
    }

    .badge-warning {
        background-color: #e67e22;
    }

    .badge-success {
        background-color: #27ae60;
    }

    .badge-primary {
        background-color: #2980b9;
    }

    .badge-danger {
        background-color: #e74c3c;
    }

    /* Responsif */
    @media (max-width: 768px) {
        .profile-container {
            flex-direction: column;
        }

        .settings-sidebar {
            max-width: 100%;
            margin-bottom: 20px;
        }
    }

    /* Styling untuk tabel */
    .table {
        width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 1rem;
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
        text-align: center;
    }

    .table th {
        background-color: #343a40;
        color: #fff;
        font-weight: bold;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6;
    }

    /* Modern look for badges */
    .badge {
        padding: 0.5em 0.75em;
        font-size: 0.875rem;
        border-radius: 0.25rem;
        text-transform: capitalize;
    }

    /* Hover effect on table rows */
    .table-hover tbody tr:hover td {
        background-color: #f1f1f1;
        transition: background-color 0.3s ease;
    }

    /* Border radius for the table */
    .table {
        border-radius: 12px;
        overflow: hidden;
    }
</style>
@endpush
@endsection
