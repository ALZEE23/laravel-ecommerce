<?php

namespace App\Livewire\Order;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class GetOrder extends Component
{
    use WithPagination;

    public $editingOrderId = null;

    protected $listeners = ['orderUpdated' => 'handleOrderUpdated'];

    public function editOrder($orderId)
    {
        $this->editingOrderId = $orderId;
    }

    public function handleOrderUpdated()
    {
        $this->editingOrderId = null;
    }

    public function deleteOrder(Order $order)
    {
        if (!$order->canBeCancelled()) {
            session()->flash('error', 'This order cannot be deleted.');
            return;
        }

        $order->delete();
        session()->flash('status', 'Order deleted successfully.');
    }

    public function cancelOrder(Order $order)
    {
        // Check if user is authorized to cancel this order
        if (!auth()->user()->is_admin && $order->user_id !== auth()->id()) {
            session()->flash('error', 'You are not authorized to cancel this order.');
            return;
        }

        // Check if order can be cancelled
        if ($order->status !== 'pending') {
            session()->flash('error', 'Only pending orders can be cancelled.');
            return;
        }

        try {
            $order->update(['status' => 'cancelled']);
            session()->flash('status', 'Order cancelled successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to cancel order.');
        }
    }

    public function render()
    {
        $query = Order::with(['user', 'promotion'])->latest();

        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        return view('livewire.order.get-order', [
            'orders' => $query->paginate(10),
            'editingOrder' => $this->editingOrderId ? Order::find($this->editingOrderId) : null
        ]);
    }
}
