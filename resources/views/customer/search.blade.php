@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center" style="font-weight: bold;">Pencarian Produk</h1>

        <!-- Form Pencarian dan Filter -->
        <form action="{{ route('search') }}" method="GET">
            <div class="row mb-4">
                <!-- Pencarian Kata Kunci -->
                <div class="col-md-4 mb-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}" style="border-radius: 30px; border: 1px solid #007bff;">
                </div>

                <!-- Filter Kategori -->
                <div class="col-md-3 mb-2">
                    <select name="category" class="form-control" style="border-radius: 30px; border: 1px solid #007bff;">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Harga Minimum -->
                <div class="col-md-2 mb-2">
                    <input type="number" name="min_price" class="form-control" placeholder="Harga Min" value="{{ request('min_price') }}" style="border-radius: 30px; border: 1px solid #007bff;">
                </div>

                <!-- Filter Harga Maksimum -->
                <div class="col-md-2 mb-2">
                    <input type="number" name="max_price" class="form-control" placeholder="Harga Max" value="{{ request('max_price') }}" style="border-radius: 30px; border: 1px solid #007bff;">
                </div>

                <!-- Tombol Submit -->
                <div class="col-md-1 mb-2">
                    <button type="submit" class="btn btn-primary btn-block" style="border-radius: 30px; transition: background-color 0.3s;">
                        Cari
                    </button>
                </div>
            </div>
        </form>

        <!-- Daftar Produk -->
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: transform 0.2s;">
                        <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="max-height: 250px; object-fit: cover; border-radius: 15px 15px 0 0;">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-truncate">{{ $product->description }}</p>
                            <p class="card-text"><strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong></p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-block" style="border-radius: 30px;">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">Tidak ada produk yang ditemukan.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
@endsection
