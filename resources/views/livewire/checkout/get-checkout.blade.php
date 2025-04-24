<div class="py-6">
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Checkout #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment Method</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($checkouts as $checkout)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">#{{ $checkout->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">#{{ $checkout->order->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $checkout->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($checkout->payment_method) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($checkout->order->total_price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $checkout->status === 'paid' ? 'bg-green-100 text-green-800' :
                    ($checkout->status === 'failed' ? 'bg-red-100 text-red-800' :
                        'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($checkout->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $checkout->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    @if(auth()->user()->is_admin && $checkout->isPending())
                                        <button wire:click="markAsPaid({{ $checkout->id }})"
                                            wire:confirm="Are you sure this payment has been received?"
                                            class="text-green-600 hover:text-green-900">
                                            Mark as Paid
                                        </button>
                                    @endif
                                </td>
                            </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $checkouts->links() }}
        </div>
    </div>

    @if(session()->has('status'))
        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-md">
            {{ session('status') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-md">
            {{ session('error') }}
        </div>
    @endif
</div>