<?php

use App\Http\Controllers\AdminDashboardController;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\ContactInfoController;
use App\Http\Controllers\AdminAboutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QrisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Route untuk halaman beranda
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/about', [AboutController::class, 'index'])->name('about.index');

// Route untuk menampilkan daftar media
Route::middleware(['admin'])->group(function () {
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::get('/media/create', [MediaController::class, 'create'])->name('media.create');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::get('/media/{id}/edit', [MediaController::class, 'edit'])->name('media.edit');
    Route::put('/media/{id}', [MediaController::class, 'update'])->name('media.update');
    Route::get('/media/file/{id}', [MediaController::class, 'showMediaFile'])->name('media.show.file');

    Route::put('admin/logo', [SettingsController::class, 'updateLogo'])->name('admin.logo.update');

// Route untuk update status order
    Route::put('/customer/orders/{order}/status', [AdminDashboardController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');
    Route::post('/admin/orders/bulk-update', [AdminDashboardController::class, 'bulkUpdateOrderStatus'])->name('admin.bulkUpdateOrderStatus');

    // Route untuk chart harian
    Route::get('/sales/daily', [ChartController::class, 'areaChartController']);
    Route::get('/admin/dashboard', [ChartController::class, 'donutChartController'])->name('admin.index');


    // routes/web.php
    Route::get('/admin/qr', [QrisController::class, 'showQrSettings'])->name('admin.qr.settings');
    Route::put('/admin/qr', [QrisController::class, 'updateQr'])->name('admin.qr.update');

    Route::get('admin/settings', function () {
        return view('admin.logo.settings');
    })->name('admin.settings');

});


// Route untuk Produk
Route::prefix('user')->group(function () {
    Route::get('/products/new', [ProductController::class, 'newProducts'])->name('products.new');
    Route::get('/products', [ProductController::class, 'userIndex'])->name('component.products');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
});

// Route untuk Admin Produk
Route::prefix('admin/products')->middleware('admin')->group(function () {
    Route::get('/', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
});

// Route untuk login dan registrasi
Route::prefix('auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);

        Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
        Route::get('/register-success', [AuthController::class, 'showRegistrationSuccess'])->name('register.success');
    });

    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');

    // Route untuk reset password
    Route::get('password/reset', [AuthController::class, 'showResetRequestForm'])->name('password.request');
    Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');
    Route::get('/password/change', [AuthController::class, 'showChangePasswordForm'])->name('password.change.form');
    Route::post('/password/change', [AuthController::class, 'changePassword'])->name('password.change');

    // Route untuk OTP
    Route::get('otp/form', [AuthController::class, 'showOtpForm'])->name('otp.form');
    Route::post('otp/verify', [AuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('otp/resend', [AuthController::class, 'resendOtp'])->name('otp.resend');

    // Route untuk verifikasi email
    Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])
        ->name('verification.notice');

    Route::post('/email/resend', [AuthController::class, 'resendVerificationEmail'])
        ->name('verification.send');

    Route::get('/email/verify/{token}', [AuthController::class, 'verifyEmail'])
        ->name('verification.verify');
});

Route::get('/auth/email/verify/{token}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

// Rute dilindungi oleh middleware auth dan verified
Route::middleware(['auth', 'verified'])->group(function () {
    // Route untuk dashboard
    Route::get('/transaksi/products', [DashboardController::class, 'index'])->name('dashboard');

    // Routes untuk Admin
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/transaksi', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/order-history', [AdminDashboardController::class, 'orderHistory'])->name('orderHistory');
        Route::get('/admin/editTop', [AdminDashboardController::class, 'edit'])->name('editTop');
        Route::post('/update-media', [AdminDashboardController::class, 'update'])->name('update-media');
    });

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/admins', [UserController::class, 'showAdmins'])->name('users.admins');
        Route::post('/user/make-admin', [UserController::class, 'makeAdmin'])->name('users.makeAdmin');
        Route::get('/user/add-admin', [UserController::class, 'showAddAdminForm'])->name('users.showAddAdminForm');
        Route::put('/user/{id}/remove-admin', [UserController::class, 'removeAdmin'])->name('users.removeAdmin');
    });


    // Route untuk profil
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
    });

    // Route untuk kategori
    Route::prefix('admin')->middleware('admin')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::get('categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
    });

    // Route untuk chart
    Route::get('/admin/chart', [ChartController::class, 'donutChartController'])->name('admin.chart');

    // Routes untuk Cart
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/', [CartController::class, 'store'])->name('cart.store');
        Route::get('/increase/{id}', [CartController::class, 'increaseQuantity'])->name('cart.increaseQuantity');
        Route::get('/decrease/{id}', [CartController::class, 'decreaseQuantity'])->name('cart.decreaseQuantity');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::get('/summary', [CartController::class, 'summary'])->name('cart.summary');
    });

    // Route untuk halaman checkout
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // Route untuk halaman pesan setelah pemesanan
    Route::get('/order/message', function () {
        return view('customer.message')->with('orderCode', request()->get('orderCode'));
    })->name('order.message');
});

// Route untuk update alamat
Route::put('/address/{id}', [AddressController::class, 'update'])->name('address.update');


Route::get('/admin/export-sales', function () {
    return Excel::download(new SalesExport, 'sales.xlsx');
})->name('admin.export.sales');

Route::get('/admin/export-pdf', [ExportController::class, 'exportPDF'])->name('admin.export.pdf');
Route::prefix('admin/about')->middleware('admin')->group(function () {
    Route::get('/', [AdminAboutController::class, 'index'])->name('admin.about.index');
    Route::get('/create', [AdminAboutController::class, 'create'])->name('admin.about.create');
    Route::post('/', [AdminAboutController::class, 'store'])->name('admin.about.store');
    Route::get('/{about}/edit', [AdminAboutController::class, 'edit'])->name('admin.about.edit');
    Route::put('/{about}', [AdminAboutController::class, 'update'])->name('admin.about.update');
    Route::delete('/{about}', [AdminAboutController::class, 'destroy'])->name('admin.about.destroy');
});





Route::prefix('contacts')->middleware('admin')->group(function () {
    Route::get('/', [ContactInfoController::class, 'index'])->name('contacts.index'); // Menampilkan semua kontak
    Route::get('/create', [ContactInfoController::class, 'create'])->name('contacts.create'); // Menampilkan formulir untuk membuat kontak baru
    Route::post('/', [ContactInfoController::class, 'store'])->name('contacts.store'); // Menyimpan kontak baru
    Route::get('/{contact}/edit', [ContactInfoController::class, 'edit'])->name('contacts.edit'); // Menampilkan formulir untuk mengedit kontak
    Route::put('/{contact}', [ContactInfoController::class, 'update'])->name('contacts.update'); // Memperbarui kontak
    Route::delete('/{contact}', [ContactInfoController::class, 'destroy'])->name('contacts.destroy'); // Menghapus kontak
});
