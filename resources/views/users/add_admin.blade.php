@extends('layouts.sidebar')

@section('content')
<div class="container">
    <h1>Tambah Admin</h1>
    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('admin.users.makeAdmin') }}" method="POST">
                @csrf
                @method('POST') <!-- Menyertakan metode PUT -->
                <div class="form-group">
                    <label for="user_id">Pilih User untuk Dijadikan Admin:</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">-- Pilih User --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success mt-3">Jadikan Admin</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
