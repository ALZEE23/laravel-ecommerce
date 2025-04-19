<?php

namespace App\Livewire\Order;

use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use Livewire\Component;

class PostOrder extends Component
{
    public $user_id;
    public $product_id;
    public $quantity = 1;
    public $promotion_id;
    public $payment_method;
    public $shipping_address;
    public $notes;

    public function mount()
    {
        $this->products = Product::where('stock', '>', 0)->get();
    }

    public function rules()
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'string'],
            'shipping_address' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'promotion_id' => ['nullable', 'exists:promotions,id'],
        ];
    }

    public function calculateTotal()
    {
        if (!$this->product_id) {
            return [0, 0];
        }

        $product = Product::find($this->product_id);
        $total = $product->price * $this->quantity;

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
        $validated = $this->validate();

        // Check stock availability
        $product = Product::find($this->product_id);
        if ($product->stock < $this->quantity) {
            session()->flash('error', 'Insufficient stock for ' . $product->name);
            return;
        }

        list($total, $discount) = $this->calculateTotal();

        try {
            // Start transaction
            \DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'product_id' => $this->product_id,
                'quantity' => $this->quantity,
                'total_price' => $total,
                'promotion_id' => $this->promotion_id,
                'discount_amount' => $discount,
                'status' => 'pending',
                'payment_method' => $this->payment_method,
                'shipping_address' => $this->shipping_address,
                'notes' => $this->notes,
            ]);

            // Reduce stock
            $product->decrement('stock', $this->quantity);

            \DB::commit();
            session()->flash('status', 'Order created successfully.');

            return $this->redirect(route('order'), navigate: true);

        } catch (\Exception $e) {
            \DB::rollBack();
            session()->flash('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.order.post-order', [
            'products' => $this->products,
            'promotions' => Promotion::valid()->get(),
            'total' => $this->calculateTotal()[0],
            'discount' => $this->calculateTotal()[1],
        ]);
    }

    public function updatedProductId()
    {
        // Reset quantity when product changes
        $this->quantity = 1;
    }
}
