<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\ExchangeRate;

class Catalogo extends Component
{
    public function render()
    {
        $productos = Product::with('category')->get();
        $activeRate = ExchangeRate::getActiveRate();
        $tasaBcv = $activeRate ? $activeRate->rate : 0;

        return view('livewire.catalogo', [
            'productos' => $productos,
            'tasaBcv' => $tasaBcv
        ])->layout('components.layouts.app'); 
    }
}