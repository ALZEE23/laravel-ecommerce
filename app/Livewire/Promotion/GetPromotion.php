<?php

namespace App\Livewire\Promotion;

use App\Models\Promotion;
use Livewire\Component;
use Livewire\WithPagination;

class GetPromotion extends Component
{
    use WithPagination;

    public function deletePromotion(Promotion $promotion)
    {
        $promotion->delete();
        session()->flash('status', 'Promotion deleted successfully.');
    }

    public function render()
    {
        return view('livewire.promotion.get-promotion', [
            'promotions' => Promotion::latest()->paginate(10)
        ]);
    }
}
