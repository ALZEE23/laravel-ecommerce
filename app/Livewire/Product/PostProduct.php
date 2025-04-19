<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PostProduct extends Component
{
    use WithFileUploads;

    public $name;
    public $description;
    public $price;
    public $stock;
    public $category_id;
    public $image;

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'max:1024'], // 1MB Max
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->image) {
            $validated['image'] = $this->image->store('products', 'public');
        }

        Product::create($validated);

        session()->flash('status', 'Product created successfully.');

        return $this->redirect(route('product'), navigate: true);
    }

    public function render()
    {
        return view('livewire.product.post-product', [
            'categories' => Category::all()
        ]);
    }
}
