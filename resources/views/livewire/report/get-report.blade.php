<div class="py-6">
    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <div class="mb-4">
        <select wire:model.live="selectedType" class="rounded-md border-gray-300">
            <option value="">All Types</option>
            @foreach($types as $type)
                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
            @endforeach
        </select>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($reports as $report)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $report->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $report->type === 'sales' ? 'bg-blue-100 text-blue-800' :
                    ($report->type === 'expense' ? 'bg-red-100 text-red-800' :
                        ($report->type === 'inventory' ? 'bg-yellow-100 text-yellow-800' :
                            'bg-green-100 text-green-800')) }}">
                                        {{ ucfirst($report->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">${{ $report->formatted_total }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $report->period_start->format('M d, Y') }} -
                                    {{ $report->period_end->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $report->period_duration }} days</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $report->isCurrentPeriod() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $report->isCurrentPeriod() ? 'Current' : 'Past' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.reports.edit', $report) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        Edit
                                    </a>
                                    <button wire:click="deleteReport({{ $report->id }})"
                                        wire:confirm="Are you sure you want to delete this report?"
                                        class="text-red-600 hover:text-red-900">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $reports->links() }}
        </div>
    </div>
</div>