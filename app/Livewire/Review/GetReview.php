<?php

namespace App\Livewire\Review;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;

class GetReview extends Component
{
    use WithPagination;

    public $showVerifiedOnly = false;

    public function deleteReview(Review $review)
    {
        $review->delete();
        session()->flash('status', 'Review deleted successfully.');
    }

    public function updatedShowVerifiedOnly()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Review::with(['user', 'product']);

        if ($this->showVerifiedOnly) {
            $query->verified();
        }

        return view('livewire.review.get-review', [
            'reviews' => $query->latest()->paginate(10)
        ]);
    }
}
