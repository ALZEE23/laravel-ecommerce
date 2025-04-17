<div class="py-6">
    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <div class="mb-4">
        <label class="inline-flex items-center">
            <input type="checkbox" wire:model.live="showVerifiedOnly"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <span class="ml-2">Show Verified Purchases Only</span>
        </label>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comment
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($reviews as $review)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $review->product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $review->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {!! $review->star_rating !!}
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-xs truncate">{{ $review->comment }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($review->isVerifiedPurchase())
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Verified Purchase
                                </span>
                            @else
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Unverified
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $review->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('admin.reviews.edit', $review) }}"
                                class="text-indigo-600 hover:text-indigo-900">
                                Edit
                            </a>
                            <button wire:click="deleteReview({{ $review->id }})"
                                wire:confirm="Are you sure you want to delete this review?"
                                class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $reviews->links() }}
        </div>
    </div>
</div>