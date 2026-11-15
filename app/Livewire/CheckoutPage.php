<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Auth;

class CheckoutPage extends Component
{
    use WithFileUploads;

    public $cart = [];
    public $tasaBcv = 0;
    public $totalUsd = 0;
    public $setting;
    public $settings;

    // Envío
    public $shipping_method = 'retiro';
    public $shipping_cost = 0;
    
    // Datos del Cliente
    public $customer_phone = '';
    public $customer_address = '';
    
    // Delivery Local (Mapa)
    public $latitude = null;
    public $longitude = null;

    // Envío Nacional
    public $national_agency = '';
    public $national_destination = '';

    // Archivos
    public $payment_receipt; 
    public $customization_file; 
    public $customization_notes = ''; 

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        
        if (empty($this->cart)) {
            return redirect()->route('home');
        }

        $activeRate = ExchangeRate::getActiveRate();
        $this->tasaBcv = $activeRate ? $activeRate->rate : 0;
        $this->setting = Setting::first();
        $this->settings = Setting::first();

        $this->totalUsd = collect($this->cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function updatedShippingMethod($value)
    {
        // Reseteamos campos al cambiar de método
        $this->shipping_cost = 0;
        $this->latitude = null;
        $this->longitude = null;
        $this->customer_address = '';
        $this->national_agency = '';
        $this->national_destination = '';

        if ($value === 'delivery' && $this->settings) {
            $this->shipping_cost = $this->settings->delivery_cost;
        }
    }

    public function placeOrder()
    {
        // Validaciones condicionales
        $rules = [
            'customer_phone' => 'required|string',
            'payment_receipt' => 'required|image|max:5120',
            'customization_file' => 'required|image|max:5120',
            'shipping_method' => 'required|string',
        ];

        if ($this->shipping_method === 'delivery') {
            $rules['customer_address'] = 'required|string';
            $rules['latitude'] = 'required';
            $rules['longitude'] = 'required';
        } elseif ($this->shipping_method === 'nacional') {
            $rules['national_agency'] = 'required|string';
            $rules['national_destination'] = 'required|string';
        }

        $this->validate($rules);

        $totalFinal = $this->totalUsd + $this->shipping_cost;

        // Preparamos los detalles de envío
        $shipping_details = '';
        if ($this->shipping_method === 'delivery') {
            $shipping_details = "Dirección: {$this->customer_address} | Coordenadas: {$this->latitude}, {$this->longitude}";
        } elseif ($this->shipping_method === 'nacional') {
            $shipping_details = "Agencia: {$this->national_agency} | Destino: {$this->national_destination}";
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'customer_name' => Auth::user()->name, 
            'customer_phone' => $this->customer_phone,
            'customer_address' => $this->customer_address, // Se llena si es delivery
            'total' => $totalFinal,
            'status' => 'pendiente',
            'sale_type' => 'online', 
            'payment_receipt_path' => $this->payment_receipt->store('comprobantes', 'public'),
            'shipping_method' => $this->shipping_method,
            'shipping_details' => $shipping_details,
            'shipping_cost' => $this->shipping_cost,
            'latitude' => $this->latitude,   // ✅ Nuevo
            'longitude' => $this->longitude, // ✅ Nuevo
        ]);

        foreach ($this->cart as $id => $details) {
            $customFilePath = null;
            if ($this->customization_file) {
                $customFilePath = $this->customization_file->store('disenos', 'public');
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
                'customization_file_path' => $customFilePath,
                'customization_notes' => $this->customization_notes,
            ]);

            $product = Product::find($id);
            if ($product) {
                $product->decrement('stock', $details['quantity']);
            }
        }

        session()->forget('cart');

        // Notificar al admin
        $admins = \App\Models\User::where('role', 'admin')->get();
        if ($admins->count() > 0) {
            foreach ($admins as $admin) {
                $admin->notify(
                    \Filament\Notifications\Notification::make()
                        ->title('¡Nuevo Pedido Online!')
                        ->body("Pedido #{$order->id} de {$order->customer_name} por \${$order->total}.")
                        ->toDatabase()
                );
            }
        }

        session()->flash('success', '¡Tu pedido ha sido enviado con éxito! Pronto validaremos tu pago.');
        return redirect()->route('my-orders'); 
    }

    public function render()
    {
        // Procesamos las agencias nacionales
        $agencias = [];
        if ($this->settings && $this->settings->national_agencies) {
            $agencias = array_map('trim', explode(',', $this->settings->national_agencies));
        }

        return view('livewire.checkout-page', [
            'agencias' => $agencias
        ])->layout('components.layouts.app');
    }
}