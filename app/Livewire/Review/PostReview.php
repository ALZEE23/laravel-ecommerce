<?php

namespace App\Livewire\Review;

use App\Models\Review;
use App\Models\Product;
use Livewire\Component;

class PostReview extends Component
{
    public $user_id;
    public $product_id;
    public $rating = 5;
    public $comment;

    public function mount()
    {
        $this->user_id = auth()->id();
    }

    public function rules()
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10'],
        ];
    }

    public function save()
    {
        $validated = $this->validate();
        $validated['user_id'] = $this->user_id;

        Review::create($validated);

        session()->flash('status', 'Review posted successfully.');

        return $this->redirect(route('admin.reviews.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.review.post-review', [
            'products' => Product::orderBy('name')->get()
        ]);
    }
}
