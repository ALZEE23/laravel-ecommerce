<?php

namespace App\Livewire\Review;

use App\Models\Review;
use App\Models\Product;
use Livewire\Component;

class UpdateReview extends Component
{
    public Review $review;
    public $product_id;
    public $rating;
    public $comment;

    public function mount(Review $review)
    {
        $this->review = $review;
        $this->product_id = $review->product_id;
        $this->rating = $review->rating;
        $this->comment = $review->comment;
    }

    public function rules()
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10'],
        ];
    }

    public function update()
    {
        $validated = $this->validate();

        $this->review->update($validated);

        session()->flash('status', 'Review updated successfully.');

        return $this->redirect(route('admin.reviews.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.review.update-review', [
            'products' => Product::orderBy('name')->get()
        ]);
    }
}
