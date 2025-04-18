<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;

class UpdateCategory extends Component
{
    public Category $category;
    public ?string $name = null;
    public ?string $description = null;

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->description = $category->description;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $this->category->id],
            'description' => ['nullable', 'string'],
        ];
    }

    public function update()
    {
        $validated = $this->validate();

        $this->category->update($validated);

        session()->flash('status', 'Category updated successfully.');

        return $this->redirect(route('admin.categories.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.category.update-category');
    }
}
