<?php

namespace App\Livewire\Order;

use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use Livewire\Component;

class PostOrder extends Component
{
    public $user_id;
    public $products = [];
    public $promotion_id;
    public $payment_method;
    public $shipping_address;
    public $notes;
    public $selectedProducts = [];
    public $quantities = [];

    public function mount()
    {
        $this->products = Product::where('stock', '>', 0)->get();
    }

    public function rules()
    {
        return [
            'selectedProducts' => ['required', 'array', 'min:1'],
            'quantities.*' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'string'],
            'shipping_address' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'promotion_id' => ['nullable', 'exists:promotions,id'],
        ];
    }

    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->selectedProducts as $productId) {
            $product = Product::find($productId);
            $quantity = $this->quantities[$productId] ?? 1;
            $total += $product->price * $quantity;
        }

        if ($this->promotion_id) {
            $promotion = Promotion::find($this->promotion_id);
            if ($promotion && $promotion->isValid()) {
                $discount = $promotion->calculateDiscount($total);
                return [$total, $discount];
            }
        }

        return [$total, 0];
    }

    public function save()
    {
        $this->validate();

        list($total, $discount) = $this->calculateTotal();

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $total,
            'promotion_id' => $this->promotion_id,
            'discount_amount' => $discount,
            'status' => 'pending',
            'payment_method' => $this->payment_method,
            'shipping_address' => $this->shipping_address,
            'notes' => $this->notes,
        ]);

        session()->flash('status', 'Order created successfully.');

        return $this->redirect(route('admin.orders.index'), navigate: true);
    }

    public function render()
    {
        $promotions = Promotion::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        return view('livewire.order.post-order', [
            'promotions' => $promotions,
            'total' => $this->calculateTotal()[0],
            'discount' => $this->calculateTotal()[1],
        ]);
    }
}
