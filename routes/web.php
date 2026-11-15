<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Catalogo;
use App\Livewire\CartPage;
use App\Livewire\CheckoutPage;
use App\Livewire\ProductDetail;
use App\Livewire\MyOrders;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoiceController;

// ✅ Página de Inicio (Solo Categorías e Info)
Route::get('/', Home::class)->name('home');

// ✅ Página del Catálogo Completo (Productos y Buscador)
Route::get('/catalogo', Catalogo::class)->name('catalogo');

// Tienda
Route::get('/carrito', CartPage::class)->name('cart');
Route::get('/producto/{id}', ProductDetail::class)->name('product.detail');

// Rutas Protegidas
Route::middleware('auth')->group(function () {
    Route::get('/checkout', CheckoutPage::class)->name('checkout');
    Route::get('/mis-pedidos', MyOrders::class)->name('my-orders');
    Route::get('/factura/{order}', [InvoiceController::class, 'download'])->name('download.invoice');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';