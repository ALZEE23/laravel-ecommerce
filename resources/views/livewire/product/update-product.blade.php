<div>
    <form wire:submit="update" class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <div>
                <x-input-label for="name" :value="__('Product Name')" />
                <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="description" :value="__('Description')" />
                <x-textarea wire:model="description" id="description" class="block mt-1 w-full" rows="4" required />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="price" :value="__('Price')" />
                    <x-text-input wire:model="price" id="price" class="block mt-1 w-full" type="number" step="0.01"
                        required />
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="stock" :value="__('Stock')" />
                    <x-text-input wire:model="stock" id="stock" class="block mt-1 w-full" type="number" required />
                    <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                </div>
            </div>

            <div>
                <x-input-label for="category_id" :value="__('Category')" />
                <select wire:model="category_id" id="category_id"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="newImage" :value="__('Product Image')" />
                <input type="file" wire:model="newImage" id="newImage"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                <div class="mt-2 text-sm text-gray-500">Maximum file size: 1MB</div>
                <x-input-error :messages="$errors->get('newImage')" class="mt-2" />

                <div class="mt-4 flex space-x-4">
                    @if ($newImage)
                        <div>
                            <div class="text-sm font-medium text-gray-500">New Image:</div>
                            <img src="{{ $newImage->temporaryUrl() }}" class="mt-2 h-32 w-32 object-cover rounded-lg">
                        </div>
                    @endif

                    @if ($image)
                        <div>
                            <div class="text-sm font-medium text-gray-500">Current Image:</div>
                            <img src="{{ $product->image_url }}" class="mt-2 h-32 w-32 object-cover rounded-lg">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <x-secondary-button type="button" wire:click="$dispatch('cancel')">
                Cancel
            </x-secondary-button>
            <x-primary-button>
                Update Product
            </x-primary-button>
        </div>
    </form>
</div>