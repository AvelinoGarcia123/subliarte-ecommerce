<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;

class Home extends Component
{
    public function render()
    {
        $categorias = Category::withCount('products')->get();
        $destacados = Product::with('category')->latest()->take(4)->get();

        return view('livewire.home', [
            'categorias' => $categorias,
            'destacados' => $destacados,
        ])->layout('components.layouts.app');
    }
}