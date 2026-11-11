<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Catalogo;
use App\Livewire\CartPage;
use App\Livewire\CheckoutPage;
use App\Http\Controllers\ProfileController;
use App\Livewire\ProductDetail;

// 1. Ruta del catálogo (Página principal de la tienda)
Route::get('/', Catalogo::class)->name('home');

// 2. Ruta del Carrito de Compras
Route::get('/carrito', CartPage::class)->name('cart');

// 3. Ruta del Checkout (Pago) - Protegida para que solo entren usuarios logueados
Route::get('/checkout', CheckoutPage::class)->middleware('auth')->name('checkout');
Route::get('/producto/{id}', ProductDetail::class)->name('product.detail');

// 4. Rutas del perfil del cliente (Laravel Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';