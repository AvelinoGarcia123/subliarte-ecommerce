<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\ExchangeRate;

class Catalogo extends Component
{
    public $search = '';
    public $selectedCategory = null;

    public function mount($category = null)
    {
        $this->selectedCategory = $category;
    }

    public function filterByCategory($id = null)
    {
        $this->selectedCategory = $id;
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        if (!$product || $product->stock <= 0) return;

        $cart = session()->get('cart', []);

        if(isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image_path
            ];
        }

        session()->put('cart', $cart);
        $this->dispatch('cart-updated', count: count($cart));
        session()->flash('message', '¡Producto añadido al carrito!');
    }

    public function render()
    {
        $query = Product::with('category');

        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $productos = $query->get();
        $quickResults = !empty($this->search) ? $query->take(4)->get() : collect();
        $categorias = Category::withCount('products')->get();

        $activeRate = ExchangeRate::getActiveRate();
        $tasaBcv = $activeRate ? $activeRate->rate : 0;

        return view('livewire.catalogo', [
            'productos' => $productos,
            'quickResults' => $quickResults,
            'categorias' => $categorias,
            'tasaBcv' => $tasaBcv
        ])->layout('components.layouts.app'); 
    }
}