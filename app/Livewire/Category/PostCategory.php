<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;

class PostCategory extends Component
{
    public string $name = '';
    public string $description = '';

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        Category::create($validated);

        session()->flash('status', 'Category created successfully.');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.category.post-category');
    }
}
