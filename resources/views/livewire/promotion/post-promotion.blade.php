<div>
    <form wire:submit="save" class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <div>
                <x-input-label for="code" :value="__('Promotion Code')" />
                <x-text-input wire:model="code" id="code" class="block mt-1 w-full" type="text" required />
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="description" :value="__('Description')" />
                <x-textarea wire:model="description" id="description" class="block mt-1 w-full" rows="3" required />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="discount_type" :value="__('Discount Type')" />
                    <select wire:model="discount_type" id="discount_type"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500">
                        <option value="percentage">Percentage (%)</option>
                        <option value="fixed">Fixed Amount ($)</option>
                    </select>
                    <x-input-error :messages="$errors->get('discount_type')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="discount_value" :value="__('Discount Value')" />
                    <x-text-input wire:model="discount_value" id="discount_value" class="block mt-1 w-full"
                        type="number" step="0.01" required />
                    <x-input-error :messages="$errors->get('discount_value')" class="mt-2" />
                </div>
            </div>

            <div>
                <x-input-label for="usage_limit" :value="__('Usage Limit')" />
                <x-text-input wire:model="usage_limit" id="usage_limit" class="block mt-1 w-full" type="number"
                    required />
                <x-input-error :messages="$errors->get('usage_limit')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="start_date" :value="__('Start Date')" />
                    <x-text-input wire:model="start_date" id="start_date" class="block mt-1 w-full" type="date"
                        required />
                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="end_date" :value="__('End Date')" />
                    <x-text-input wire:model="end_date" id="end_date" class="block mt-1 w-full" type="date" required />
                    <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" wire:model="is_active" id="is_active"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <x-input-label for="is_active" class="ml-2" :value="__('Active')" />
                <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <x-secondary-button type="button" wire:click="$dispatch('cancel')">
                Cancel
            </x-secondary-button>
            <x-primary-button>
                Create Promotion
            </x-primary-button>
        </div>
    </form>
</div>