<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaptopController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SalesAssistantController; // 👈 Newly added Controller
use App\Http\Controllers\UserController; // 👈 Controller for managing users/staff members

/*
|--------------------------------------------------------------------------
| Public Routes (Pages visible to anyone without any login)
|--------------------------------------------------------------------------
*/

// 1. Instantly goes to the Customer Shop when clicking the php artisan serve link
Route::get('/', [LaptopController::class, 'shop'])->name('customer.shop');

// 2. To view details of a laptop separately (This is what was missing before!)
Route::get('/shop/laptop/{id}', [LaptopController::class, 'show'])->name('laptop.show');

// 3. Redirects straight to the Delivery Details + Payment Method page when clicking Buy Now
Route::get('/order/{id}', [LaptopController::class, 'checkout'])->name('laptop.checkout');

// 4. Saving data when clicking the Confirm Order button on that page
Route::post('/order/confirm', [LaptopController::class, 'confirmOrder'])->name('order.confirm');

Route::post('/order/confirm', [OrderController::class, 'confirm'])->name('order.confirm');

Route::view('/about', 'about')->name('about');

Route::view('/contact', 'contact')->name('contact');


/*
|--------------------------------------------------------------------------
| Protected Routes (Pages that can only be accessed after logging in)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Showing the Admin / Sales Assistant Dashboard
    Route::get('/dashboard', [LaptopController::class, 'index'])->name('dashboard');
    Route::get('/assistant/invoice/{id}/print', [SalesAssistantController::class, 'printInvoice'])->name('assistant.invoice.print');
    
    // Form to add a new laptop
    Route::get('/laptops/create', [LaptopController::class, 'create'])->name('laptops.create');
    
    // Saving data into the Database
    Route::post('/laptops', [LaptopController::class, 'store'])->name('laptops.store');
    
    // Form to edit laptop data
    Route::get('/laptops/{id}/edit', [LaptopController::class, 'edit'])->name('laptops.edit');
    
    // Updating modified data
    Route::put('/laptops/{id}', [LaptopController::class, 'update'])->name('laptops.update');
    
    // Deleting a laptop data (Delete)
    Route::delete('/laptops/{id}', [LaptopController::class, 'destroy'])->name('laptops.destroy');

    // 🔴 Sales Assistant Counter Sale Routes (This is where the two new routes were added)
    Route::get('/assistant/counter-sale', [SalesAssistantController::class, 'create'])->name('assistant.counter_sale');
    Route::post('/assistant/counter-sale', [SalesAssistantController::class, 'store'])->name('assistant.counter_sale.store');
    
    // Get Sales Report For Admin
    Route::get('/admin/sales-report', [\App\Http\Controllers\AdminSalesController::class, 'index'])->name('admin.sales.report');

    // Admin Online Orders & Revenue Analytics Route
    Route::get('/admin/online-orders', [OrderController::class, 'onlineOrders'])->name('admin.online.orders');
    
    // Routes for Admin to Create and Store New Users/Staff Members
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');

   

    // ඇඩ්මින්ට පමණක් පරිශීලකයින් පාලනය කිරීමට (Admin User Management Routes)
    Route::middleware(['auth'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});
    
    // Sales Assistant My Sales History Route
    Route::get('/assistant/my-sales', [App\Http\Controllers\SalesAssistantController::class, 'mySales'])->name('assistant.my_sales');
});

   // Order Success Page Route
    Route::get('/order-success/{id}', [OrderController::class, 'orderSuccess'])->name('order.success');

  // Online Order Invoice Download Route
    Route::get('/order/{id}/download-invoice', [OrderController::class, 'downloadInvoice'])->name('order.invoice.download');
 use App\Http\Controllers\CartController;

// Route for adding items to the cart via AJAX
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');

// Route for Delete Crat
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

// Crat Checkout Route
Route::get('/checkout/{id?}', [LaptopController::class, 'checkout'])->name('cart.checkout');

//Online Order Satus Update
Route::put('/admin/online-orders/{id}/status', [App\Http\Controllers\LaptopController::class, 'updateStatus'])->name('admin.orders.updateStatus');


/*
|--------------------------------------------------------------------------
| Profile Routes (Provided by Laravel Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// File containing routes for the Laravel Breeze Login/Register process
require __DIR__.'/auth.php';