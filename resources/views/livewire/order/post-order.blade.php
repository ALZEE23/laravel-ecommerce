<div>
    <form wire:submit.prevent="{{ $isCalculated ? 'save' : 'calculateTotal' }}" class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">Product</h3>
            <div class="space-y-4">
                <div>
                    <x-input-label for="product_id" :value="__('Select Product')" />
                    <select wire:model="product_id" id="product_id" class="w-full rounded-md border-gray-300">
                        <option value="">Select a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }} - Rp{{ $product->formatted_price }}
                                (Stock: {{ $product->stock }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                </div>

                @if($product_id)
                    <div>
                        <x-input-label for="quantity" :value="__('Quantity')" />
                        <x-text-input wire:model="quantity" type="number" min="1"
                            max="{{ $products->find($product_id)->stock }}" class="w-20" />
                        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                    </div>
                @endif
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

                @if($payment_method === 'bank_transfer')
                    <div>
                        <img src={{ asset('images') }} alt="Bank Transfer Instructions" class="w-full h-72">
                    </div>
                @elseif($payment_method === 'credit_card')
                    <div>
                        <img src={{ asset('images') }} alt="Credit Card Instructions" class="w-full h-72">
                    </div>
                @elseif($payment_method === 'cash')
                    <div>
                        <img src={{ asset('images') }} alt="Cash Instructions" class="w-full h-72">
                    </div>
                @endif

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
                    <span>Product Price:</span>
                    <span>Rp{{ number_format($products->find($product_id)?->price ?? 0, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Quantity:</span>
                    <span>× {{ $quantity }}</span>
                </div>
                <div class="flex justify-between border-t border-gray-200 pt-2">
                    <span>Subtotal:</span>
                    <span>Rp{{ number_format($total, 2) }}</span>
                </div>
                @if($discount > 0)
                    <div class="flex justify-between text-green-600">
                        <span>Discount (@if($promotion_id){{ $promotions->find($promotion_id)?->code }}@endif):</span>
                        <span>-Rp{{ number_format($discount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between font-bold border-t border-gray-200 pt-2">
                    <span>Final Total:</span>
                    <span class="text-lg">Rp{{ number_format($total - $discount, 2) }}</span>
                </div>
            </div>

            @if($isCalculated)
                <div class="mt-4 p-3 bg-green-50 text-green-700 rounded-md text-sm">
                    <p>✓ Total calculated with applied discounts</p>
                    <p>Review the amounts above before creating the order</p>
                </div>
            @endif
        </div>

        <div class="flex justify-end space-x-4">
            <x-secondary-button type="button" wire:click="$dispatch('cancel')">
                {{ __('Cancel') }}
            </x-secondary-button>

            @if(!$isCalculated)
                <x-primary-button type="submit">
                    {{ __('Calculate Order') }}
                </x-primary-button>
            @else
                <x-secondary-button type="button" wire:click="resetCalculation">
                    {{ __('Recalculate') }}
                </x-secondary-button>
                <x-primary-button type="submit">
                    {{ __('Create Order') }}
                </x-primary-button>
            @endif
        </div>
    </form>

    <!-- Debug info during development -->
    @if(config('app.debug'))
        <div class="mt-4 p-4 bg-gray-100 rounded">
            <pre class="text-xs">
                    Product ID: {{ $product_id }}
                    Quantity: {{ $quantity }}
                    Unit Price: Rp{{ number_format($products->find($product_id)?->price ?? 0, 2) }}
                    Subtotal: Rp{{ number_format($total, 2) }}
                    Promotion: {{ $promotions->find($promotion_id)?->code ?? 'None' }}
                    Discount Amount: Rp{{ number_format($discount, 2) }}
                    Final Total: Rp{{ number_format($total - $discount, 2) }}
                    Is Calculated: {{ $isCalculated ? 'Yes' : 'No' }}
                                </pre>
        </div>
    @endif
</div>