<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class GetProduct extends Component
{
    use WithPagination;

    public $editingProductId = null;

    protected $listeners = ['productUpdated' => 'handleProductUpdated'];

    public function editProduct($productId)
    {
        $this->editingProductId = $productId;
    }

    public function handleProductUpdated()
    {
        $this->editingProductId = null;
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        session()->flash('status', 'Product deleted successfully.');
    }

    public function render()
    {
        return view('livewire.product.get-product', [
            'products' => Product::with('category')->latest()->paginate(10),
            'editingProduct' => $this->editingProductId ? Product::find($this->editingProductId) : null
        ]);
    }
}
