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

    public function render()
    {
        $query = Order::with(['user', 'promotion'])->latest();

        if(!auth()->user()->isAdmin()) {
            $query->where('user_id',auth()->id());
        } 


        return view('livewire.order.get-order', [
            'orders' => $query->paginate(10),
            'editingOrder' => $this->editingOrderId ? Order::find($this->editingOrderId) : null
        ]);
    }
}
