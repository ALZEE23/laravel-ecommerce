<?php

namespace App\Livewire\Report;

use App\Models\Report;
use Livewire\Component;
use Livewire\WithPagination;

class GetReport extends Component
{
    use WithPagination;

    public $selectedType = '';

    public function deleteReport(Report $report)
    {
        $report->delete();
        session()->flash('status', 'Report deleted successfully.');
    }

    public function updatedSelectedType()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Report::query();

        if ($this->selectedType) {
            $query->ofType($this->selectedType);
        }

        return view('livewire.report.get-report', [
            'reports' => $query->latest()->paginate(10),
            'types' => ['sales', 'expense', 'inventory', 'revenue']
        ]);
    }
}
