<?php

namespace App\Livewire\Checkout;

use App\Models\Checkout;
use Livewire\Component;
use Livewire\WithPagination;

class GetCheckout extends Component
{
    use WithPagination;

    public function markAsPaid($checkoutId)
    {
        if (!auth()->user()->is_admin) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        $checkout = Checkout::findOrFail($checkoutId);

        if (!$checkout->isPending()) {
            session()->flash('error', 'Checkout is not in pending status.');
            return;
        }

        if ($checkout->markAsPaid()) {
            session()->flash('status', 'Payment marked as received successfully.');
        } else {
            session()->flash('error', 'Failed to update payment status.');
        }
    }

    public function render()
    {
        $query = Checkout::with(['user', 'order'])->latest();

        
        if (!auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        }

        return view('livewire.checkout.get-checkout', [
            'checkouts' => $query->paginate(10)
        ]);
    }
}
