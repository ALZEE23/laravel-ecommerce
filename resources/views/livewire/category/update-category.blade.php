<div>
    <form wire:submit="update" class="space-y-4">
        <div>
            <x-input-label for="name" :value="__('Category Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <x-textarea wire:model="description" id="description" class="block mt-1 w-full" rows="3" />
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Update Category') }}</x-primary-button>

            <x-secondary-button wire:click="$dispatch('cancel')" type="button">
                {{ __('Cancel') }}
            </x-secondary-button>

            @if (session('status'))
                <p class="text-sm text-gray-600">{{ session('status') }}</p>
            @endif
        </div>
    </form>
</div>