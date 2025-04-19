<?php

namespace App\Livewire\Promotion;

use App\Models\Promotion;
use Livewire\Component;
use Livewire\WithPagination;

class GetPromotion extends Component
{
    use WithPagination;

    public $editingPromotionId = null;

    protected $listeners = ['promotionUpdated' => 'handlePromotionUpdated'];

    public function editPromotion($promotionId)
    {
        $this->editingPromotionId = $promotionId;
    }

    public function handlePromotionUpdated()
    {
        $this->editingPromotionId = null;
    }

    public function deletePromotion(Promotion $promotion)
    {
        $promotion->delete();
        session()->flash('status', 'Promotion deleted successfully.');
    }

    public function render()
    {
        return view('livewire.promotion.get-promotion', [
            'promotions' => Promotion::latest()->paginate(10),
            'editingPromotion' => $this->editingPromotionId ? Promotion::find($this->editingPromotionId) : null
        ]);
    }
}
