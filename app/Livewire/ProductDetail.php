<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\ExchangeRate;

class ProductDetail extends Component
{
    public $product;
    public $tasaBcv = 0;

    public function mount($id)
    {
        // Buscamos el producto por su ID
        $this->product = Product::with('category')->findOrFail($id);
        
        // Obtenemos la tasa BCV
        $activeRate = ExchangeRate::getActiveRate();
        $this->tasaBcv = $activeRate ? $activeRate->rate : 0;
    }

    public function addToCart()
    {
        if ($this->product->stock <= 0) return;

        $cart = session()->get('cart', []);

        if(isset($cart[$this->product->id])) {
            $cart[$this->product->id]['quantity']++;
        } else {
            $cart[$this->product->id] = [
                "name" => $this->product->name,
                "quantity" => 1,
                "price" => $this->product->price,
                "image" => $this->product->image_path
            ];
        }

        session()->put('cart', $cart);
        
        // Redirigir al carrito después de agregar
        return redirect()->route('cart');
    }

    public function render()
    {
        return view('livewire.product-detail')->layout('components.layouts.app');
    }
}