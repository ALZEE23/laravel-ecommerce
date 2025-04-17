<div>
    <form wire:submit="update" class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">Order #{{ $order->id }}</h3>
            <div class="space-y-4">
                <div>
                    <x-input-label for="status" :value="__('Status')" />
                    <select wire:model="status" id="status" class="w-full rounded-md border-gray-300">
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="payment_method" :value="__('Payment Method')" />
                    <select wire:model="payment_method" id="payment_method" class="w-full rounded-md border-gray-300">
                        <option value="credit_card">Credit Card</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="cash">Cash</option>
                    </select>
                    <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="promotion_id" :value="__('Promotion')" />
                    <select wire:model="promotion_id" id="promotion_id" class="w-full rounded-md border-gray-300">
                        <option value="">No Promotion</option>
                        @foreach($promotions as $promotion)
                            <option value="{{ $promotion->id }}">
                                {{ $promotion->code }} - {{ $promotion->description }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('promotion_id')" class="mt-2" />
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
                    <span>Total:</span>
                    <span>${{ $order->formatted_total_price }}</span>
                </div>
                @if($order->discount_amount)
                    <div class="flex justify-between text-green-600">
                        <span>Discount:</span>
                        <span>-${{ $order->formatted_discount_amount }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <x-secondary-button type="button" wire:click="$dispatch('cancel')">
                Cancel
            </x-secondary-button>
            <x-primary-button>
                Update Order
            </x-primary-button>
        </div>
    </form>
</div>