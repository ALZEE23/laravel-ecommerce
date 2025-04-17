<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class GetProduct extends Component
{
    use WithPagination;

    public function deleteProduct(Product $product)
    {
        $product->delete();
        session()->flash('status', 'Product deleted successfully.');
    }

    public function render()
    {
        return view('livewire.product.get-product', [
            'products' => Product::with('category')->latest()->paginate(10)
        ]);
    }
}
