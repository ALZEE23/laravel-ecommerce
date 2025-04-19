<?php

namespace App\Livewire\Order;

use App\Models\Order;
use App\Models\Promotion;
use Livewire\Component;

class UpdateOrder extends Component
{
    public Order $order;
    public $status;
    public $payment_method;
    public $shipping_address;
    public $notes;
    public $promotion_id;

    public function mount(Order $order)
    {
        $this->order = $order;
        $this->status = $order->status;
        $this->payment_method = $order->payment_method;
        $this->shipping_address = $order->shipping_address;
        $this->notes = $order->notes;
        $this->promotion_id = $order->promotion_id;
    }

    public function rules()
    {
        return [
            'status' => ['required', 'in:pending,processing,shipped,completed,cancelled'],
            'payment_method' => ['required', 'string'],
            'shipping_address' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'promotion_id' => ['nullable', 'exists:promotions,id'],
        ];
    }

    public function update()
    {
        $validated = $this->validate();

        if ($validated['promotion_id'] !== $this->order->promotion_id) {
            $promotion = Promotion::find($validated['promotion_id']);
            if ($promotion && $promotion->isValid()) {
                $discount = $promotion->calculateDiscount($this->order->total_price);
                $validated['discount_amount'] = $discount;
            }
        }

        $this->order->update($validated);

        session()->flash('status', 'Order updated successfully.');

        return $this->redirect(route('order'), navigate: true);
    }

    public function render()
    {
        $promotions = Promotion::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        return view('livewire.order.update-order', [
            'promotions' => $promotions
        ]);
    }
}
