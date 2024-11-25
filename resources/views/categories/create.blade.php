@extends('layouts.sidebar')

@section('content')
<div class="container mt-3">
    <h1>Create New Category</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" required>
        </div>

        <div class="form-group">
            <label for="color">Category Color</label>
            <input type="color" class="form-control" id="color" name="color" value="#000000" required> <!-- Input warna -->
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
