<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UpdateProduct extends Component
{
    use WithFileUploads;

    public Product $product;
    public $name;
    public $description;
    public $price;
    public $stock;
    public $category_id;
    public $image;
    public $newImage;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->category_id = $product->category_id;
        $this->image = $product->image;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'newImage' => ['nullable', 'image', 'max:1024'], // 1MB Max
        ];
    }

    public function update()
    {
        $validated = $this->validate();

        if ($this->newImage) {
            // Delete old image if exists
            if ($this->image) {
                Storage::disk('public')->delete($this->image);
            }
            $validated['image'] = $this->newImage->store('products', 'public');
        }

        unset($validated['newImage']);
        $this->product->update($validated);

        session()->flash('status', 'Product updated successfully.');

        return $this->redirect(route('admin.products.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.product.update-product', [
            'categories' => Category::all()
        ]);
    }
}
