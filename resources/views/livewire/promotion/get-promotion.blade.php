<div class="py-6">
    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usage
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Validity
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($promotions as $promotion)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $promotion->code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ ucfirst($promotion->discount_type) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($promotion->discount_type === 'percentage')
                                {{ $promotion->discount_value }}%
                            @else
                                ${{ number_format($promotion->discount_value, 2) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $promotion->getRemainingUsage() }}/{{ $promotion->usage_limit }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $promotion->start_date->format('M d, Y') }} -
                            {{ $promotion->end_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $promotion->isValid() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $promotion->isValid() ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('admin.promotions.edit', $promotion) }}"
                                class="text-indigo-600 hover:text-indigo-900">
                                Edit
                            </a>
                            <button wire:click="deletePromotion({{ $promotion->id }})"
                                wire:confirm="Are you sure you want to delete this promotion?"
                                class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $promotions->links() }}
        </div>
    </div>
</div>