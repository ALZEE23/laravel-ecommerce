<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class GetCategory extends Component
{
    use WithPagination;

    public function deleteCategory(Category $category)
    {
        $category->delete();
        session()->flash('status', 'Category deleted successfully.');
    }

    public function render()
    {
        return view('livewire.category.get-category', [
            'categories' => Category::paginate(10)
        ]);
    }
}
