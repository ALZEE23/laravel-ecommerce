<div>
    <form wire:submit="save" class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">Products</h3>
            <div class="space-y-4">
                @foreach($products as $product)
                    <div class="flex items-center space-x-4">
                        <input type="checkbox" wire:model="selectedProducts" value="{{ $product->id }}"
                            class="rounded border-gray-300">
                        <span>{{ $product->name }} - ${{ $product->formatted_price }}</span>
                        @if(in_array($product->id, $selectedProducts))
                            <input type="number" wire:model="quantities.{{ $product->id }}"
                                class="w-20 rounded-md border-gray-300" min="1" max="{{ $product->stock }}">
                        @endif
                    </div>
                @endforeach
                <x-input-error :messages="$errors->get('selectedProducts')" class="mt-2" />
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">Promotion</h3>
            <select wire:model="promotion_id" class="w-full rounded-md border-gray-300">
                <option value="">No Promotion</option>
                @foreach($promotions as $promotion)
                    <option value="{{ $promotion->id }}">
                        {{ $promotion->code }} - {{ $promotion->description }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">Payment & Shipping</h3>
            <div class="space-y-4">
                <div>
                    <x-input-label for="payment_method" :value="__('Payment Method')" />
                    <select wire:model="payment_method" id="payment_method" class="w-full rounded-md border-gray-300">
                        <option value="">Select Payment Method</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="cash">Cash</option>
                    </select>
                    <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="shipping_address" :value="__('Shipping Address')" />
                    <x-textarea wire:model="shipping_address" id="shipping_address" rows="3" />
                    <x-input-error :messages="$errors->get('shipping_address')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="notes" :value="__('Notes')" />
                    <x-textarea wire:model="notes" id="notes" rows="2" />
                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">Order Summary</h3>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                @if($discount > 0)
                    <div class="flex justify-between text-green-600">
                        <span>Discount:</span>
                        <span>-${{ number_format($discount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between font-bold">
                    <span>Total:</span>
                    <span>${{ number_format($total - $discount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <x-secondary-button type="button" wire:click="$dispatch('cancel')">
                Cancel
            </x-secondary-button>
            <x-primary-button>
                Create Order
            </x-primary-button>
        </div>
    </form>
</div>