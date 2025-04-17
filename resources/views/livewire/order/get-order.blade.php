<div class="py-6">
    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 text-sm font-medium text-red-600">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">#{{ $order->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->formatted_total_price }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' :
                    ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                        'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->payment_method }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.orders.edit', $order) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        Edit
                                    </a>
                                    @if($order->canBeCancelled())
                                        <button wire:click="deleteOrder({{ $order->id }})"
                                            wire:confirm="Are you sure you want to delete this order?"
                                            class="text-red-600 hover:text-red-900">
                                            Delete
                                        </button>
                                    @endif
                                </td>
                            </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>