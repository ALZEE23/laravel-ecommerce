<?php

namespace App\Livewire\Report;

use App\Models\Report;
use Livewire\Component;

class UpdateReport extends Component
{
    public Report $report;
    public $title;
    public $type;
    public $description;
    public $total;
    public $period_start;
    public $period_end;

    public function mount(Report $report)
    {
        $this->report = $report;
        $this->title = $report->title;
        $this->type = $report->type;
        $this->description = $report->description;
        $this->total = $report->total;
        $this->period_start = $report->period_start->format('Y-m-d');
        $this->period_end = $report->period_end->format('Y-m-d');
    }

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

    public function update()
    {
        $validated = $this->validate();

        $this->report->update($validated);

        session()->flash('status', 'Report updated successfully.');

        return $this->redirect(route('admin.reports.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.report.update-report');
    }
}
