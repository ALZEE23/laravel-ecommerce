<div>
    <form wire:submit="save" class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <div>
                <x-input-label for="product_id" :value="__('Product')" />
                <select wire:model="product_id" id="product_id"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="rating" :value="__('Rating')" />
                <div class="flex items-center space-x-2 mt-1">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" wire:click="$set('rating', {{ $i }})"
                            class="text-2xl focus:outline-none {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}">
                            ★
                        </button>
                    @endfor
                </div>
                <x-input-error :messages="$errors->get('rating')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="comment" :value="__('Your Review')" />
                <x-textarea wire:model="comment" id="comment" rows="4"
                    placeholder="Share your experience with this product..." class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('comment')" class="mt-2" />
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <x-secondary-button type="button" wire:click="$dispatch('cancel')">
                Cancel
            </x-secondary-button>
            <x-primary-button>
                Post Review
            </x-primary-button>
        </div>
    </form>
</div>