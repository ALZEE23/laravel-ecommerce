<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class GetCategory extends Component
{
    use WithPagination;

    public $editingCategoryId = null;

    protected $listeners = ['categoryUpdated' => 'handleCategoryUpdated'];

    public function editCategory(Category $category)
    {
        $this->editingCategoryId = $category->id;
    }

    public function cancelEdit()
    {
        $this->editingCategoryId = null;
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        session()->flash('status', 'Category deleted successfully.');
    }

    public function handleCategoryUpdated()
    {
        $this->editingCategoryId = null;
    }

    public function render()
    {
        return view('livewire.category.get-category', [
            'categories' => Category::latest()->paginate(10),
            'editingCategory' => $this->editingCategoryId ? Category::find($this->editingCategoryId) : null
        ]);
    }
}
