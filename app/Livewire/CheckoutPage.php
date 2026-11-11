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

    // Campos del formulario
    public $customer_phone = '';
    public $customer_address = '';
    public $payment_receipt; // Archivo del comprobante
    public $customization_file; // Archivo del diseño
    public $customization_notes = ''; // Instrucciones extra

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        
        // Si el carrito está vacío, redirigir al catálogo
        if (empty($this->cart)) {
            return redirect()->route('home');
        }

        $activeRate = ExchangeRate::getActiveRate();
        $this->tasaBcv = $activeRate ? $activeRate->rate : 0;
        $this->setting = Setting::first();

        // Calcular total
        $this->totalUsd = collect($this->cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function placeOrder()
    {
        // Validaciones
        $this->validate([
            'customer_phone' => 'required|string',
            'customer_address' => 'required|string',
            'payment_receipt' => 'required|image|max:5120', // Max 5MB
            'customization_file' => 'nullable|image|max:5120', // Opcional por si no suben diseño
        ]);

        // 1. Crear la Orden en la Base de Datos
        $order = Order::create([
            'user_id' => Auth::id(),
            'customer_name' => Auth::user()->name, // Tomamos el nombre del usuario logueado
            'customer_phone' => $this->customer_phone,
            'customer_address' => $this->customer_address,
            'total' => $this->totalUsd,
            'status' => 'pendiente',
            'sale_type' => 'online', // ¡Clave para que salga la notificación en el admin!
            'payment_receipt_path' => $this->payment_receipt->store('comprobantes', 'public'),
        ]);

        // 2. Guardar los productos y los diseños
        foreach ($this->cart as $id => $details) {
            $customFilePath = null;
            
            // Si subió un diseño, lo guardamos
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

            // 3. Descontar el stock (Inventario)
            $product = Product::find($id);
            if ($product) {
                $product->decrement('stock', $details['quantity']);
            }
        }

        // 4. Vaciar el carrito
        session()->forget('cart');

        // 5. Redirigir a una página de éxito o a "Mis Pedidos"
        session()->flash('success', '¡Tu pedido ha sido enviado! Pronto validaremos tu pago.');
        return redirect()->route('home'); 
    }

    public function render()
    {
        return view('livewire.checkout-page')->layout('components.layouts.app');
    }
}