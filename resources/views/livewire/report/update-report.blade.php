<div>
    <form wire:submit="update" class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <div>
                <x-input-label for="title" :value="__('Report Title')" />
                <x-text-input wire:model="title" id="title" class="block mt-1 w-full" type="text" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="type" :value="__('Report Type')" />
                <select wire:model="type" id="type"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500">
                    <option value="sales">Sales Report</option>
                    <option value="expense">Expense Report</option>
                    <option value="inventory">Inventory Report</option>
                    <option value="revenue">Revenue Report</option>
                </select>
                <x-input-error :messages="$errors->get('type')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="description" :value="__('Description')" />
                <x-textarea wire:model="description" id="description" class="block mt-1 w-full" rows="3" required />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="total" :value="__('Total Amount')" />
                <x-text-input wire:model="total" id="total" class="block mt-1 w-full" type="number" step="0.01"
                    required />
                <x-input-error :messages="$errors->get('total')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="period_start" :value="__('Period Start')" />
                    <x-text-input wire:model="period_start" id="period_start" class="block mt-1 w-full" type="date"
                        required />
                    <x-input-error :messages="$errors->get('period_start')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="period_end" :value="__('Period End')" />
                    <x-text-input wire:model="period_end" id="period_end" class="block mt-1 w-full" type="date"
                        required />
                    <x-input-error :messages="$errors->get('period_end')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <x-secondary-button type="button" wire:click="$dispatch('cancel')">
                Cancel
            </x-secondary-button>
            <x-primary-button>
                Update Report
            </x-primary-button>
        </div>
    </form>
</div>