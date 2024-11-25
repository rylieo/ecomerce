@extends('layouts.app')

@section('content')
    <!-- Product Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row">
                @foreach ($products as $product)
                <div class="col-md-4 col-lg-3">
                    <div class="card">
                        <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="card-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Product</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template/js/scripts.js') }}"></script>
@endsection
