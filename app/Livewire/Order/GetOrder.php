<?php

namespace App\Livewire\Order;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class GetOrder extends Component
{
    use WithPagination;

    public function deleteOrder(Order $order)
    {
        if (!$order->canBeCancelled()) {
            session()->flash('error', 'This order cannot be deleted.');
            return;
        }

        $order->delete();
        session()->flash('status', 'Order deleted successfully.');
    }

    public function render()
    {
        return view('livewire.order.get-order', [
            'orders' => Order::with(['user', 'promotion'])->latest()->paginate(10)
        ]);
    }
}
