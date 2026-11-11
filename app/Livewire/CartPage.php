<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExchangeRate;

class CartPage extends Component
{
    public $cart = [];
    public $tasaBcv = 0;

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        $activeRate = ExchangeRate::getActiveRate();
        $this->tasaBcv = $activeRate ? $activeRate->rate : 0;
    }

    public function increment($id)
    {
        if(isset($this->cart[$id])) {
            $this->cart[$id]['quantity']++;
            session()->put('cart', $this->cart);
        }
    }

    public function decrement($id)
    {
        if(isset($this->cart[$id]) && $this->cart[$id]['quantity'] > 1) {
            $this->cart[$id]['quantity']--;
            session()->put('cart', $this->cart);
        }
    }

    public function remove($id)
    {
        if(isset($this->cart[$id])) {
            unset($this->cart[$id]);
            session()->put('cart', $this->cart);
        }
    }

    public function render()
    {
        // Calculamos el total en dólares
        $totalUsd = collect($this->cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('livewire.cart-page', [
            'totalUsd' => $totalUsd
        ])->layout('components.layouts.app');
    }
}