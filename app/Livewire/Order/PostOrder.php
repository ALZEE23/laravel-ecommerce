<?php

namespace App\Livewire\Order;

use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class PostOrder extends Component
{
    public $user_id;
    public $product_id;
    public $quantity = 1;
    public $promotion_id;
    public $payment_method;
    public $shipping_address;
    public $notes;
    public $products;
    public $total = 0;
    public $discount = 0;
    public $isCalculated = false;

    public function mount()
    {
        $this->products = Product::where('stock', '>', 0)->get();
    }

    public function rules()
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'in:credit_card,bank_transfer,cash'],
            'shipping_address' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'promotion_id' => ['nullable', 'exists:promotions,id'],
        ];
    }

    public function updatedProductId()
    {
        $this->quantity = 1;
        $this->isCalculated = false;
        $this->calculateTotal();
    }

    public function updatedQuantity()
    {
        $this->isCalculated = false;
        $this->calculateTotal();
    }

    public function updatedPromotionId()
    {
        $this->isCalculated = false;
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->validate();

        $product = Product::find($this->product_id);
        if (!$product) {
            $this->total = 0;
            $this->discount = 0;
            return;
        }

        if ($product->stock < $this->quantity) {
            session()->flash('error', 'Insufficient stock for ' . $product->name);
            return;
        }

        $this->total = $product->price * $this->quantity;
        $this->discount = 0;

        if ($this->promotion_id) {
            $promotion = Promotion::find($this->promotion_id);
            if ($promotion && $promotion->isValid()) {
                $this->discount = $promotion->calculateDiscount($this->total);
            }
        }

        $this->isCalculated = true;
        session()->flash('status', 'Order calculated. Please review and confirm.');
    }

    public function resetCalculation()
    {
        $this->isCalculated = false;
    }

    public function save()
    {
        if (!$this->isCalculated) {
            session()->flash('error', 'Please calculate the order first.');
            return;
        }

        $this->validate();

        $product = Product::find($this->product_id);
        if (!$product || $product->stock < $this->quantity) {
            session()->flash('error', 'Insufficient stock for ' . $product->name);
            return;
        }

        try {
            DB::beginTransaction();

            $finalTotal = $this->total - $this->discount;

            $order = Order::create([
                'user_id' => auth()->id(),
                'product_id' => $this->product_id,
                'quantity' => $this->quantity,
                'total_price' => $finalTotal, 
                'promotion_id' => $this->promotion_id,
                'discount_amount' => $this->discount,
                'status' => 'pending',
                'payment_method' => $this->payment_method,
                'shipping_address' => $this->shipping_address,
                'notes' => $this->notes,
            ]);

            $product->decrement('stock', $this->quantity);

            DB::commit();
            session()->flash('status', 'Order created successfully.');

            return $this->redirect(route('order'), navigate: true);

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Order creation failed', [
                'error' => $e->getMessage(),
                'data' => [
                    'product_id' => $this->product_id,
                    'quantity' => $this->quantity,
                    'subtotal' => $this->total,
                    'discount' => $this->discount,
                    'final_total' => $finalTotal
                ]
            ]);
            session()->flash('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.order.post-order', [
            'products' => $this->products,
            'promotions' => Promotion::valid()->get(),
        ]);
    }
}
