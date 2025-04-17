<?php

namespace App\Livewire\Report;

use App\Models\Report;
use Livewire\Component;

class PostReport extends Component
{
    public $title;
    public $type = 'sales';
    public $description;
    public $total;
    public $period_start;
    public $period_end;

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:sales,expense,inventory,revenue'],
            'description' => ['required', 'string'],
            'total' => ['required', 'numeric', 'min:0'],
            'period_start' => ['required', 'date', 'before_or_equal:period_end'],
            'period_end' => ['required', 'date', 'after_or_equal:period_start'],
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        Report::create($validated);

        session()->flash('status', 'Report created successfully.');

        return $this->redirect(route('admin.reports.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.report.post-report');
    }
}
