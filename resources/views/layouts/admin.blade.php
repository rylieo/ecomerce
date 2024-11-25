<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <!-- Add your CSS here -->
</head>
<body>
    <nav>
        <a href="{{ route('admin.products.index') }}">Products</a>
        <a href="{{ route('admin.categories.index') }}">Categories</a>
    </nav>
    <main>
        @yield('content')
    </main>
</body>
</html>
