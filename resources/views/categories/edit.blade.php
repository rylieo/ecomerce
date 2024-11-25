@extends('layouts.sidebar')

@section('content')
<div class="container mt-3">
    <h1>Edit Category</h1>

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
        </div>

        <div class="form-group">
            <label for="color">Category Color</label>
            <input type="color" class="form-control" id="color" name="color" value="{{ $category->color }}" required> <!-- Input warna -->
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
