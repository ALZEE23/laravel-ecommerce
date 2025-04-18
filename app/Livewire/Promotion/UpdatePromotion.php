<?php

namespace App\Livewire\Promotion;

use App\Models\Promotion;
use Livewire\Component;

class UpdatePromotion extends Component
{
    public Promotion $promotion;
    public $code;
    public $description;
    public $discount_type;
    public $discount_value;
    public $usage_limit;
    public $start_date;
    public $end_date;
    public $is_active;

    public function mount(Promotion $promotion)
    {
        $this->promotion = $promotion;
        $this->code = $promotion->code;
        $this->description = $promotion->description;
        $this->discount_type = $promotion->discount_type;
        $this->discount_value = $promotion->discount_value;
        $this->usage_limit = $promotion->usage_limit;
        $this->start_date = $promotion->start_date?->format('Y-m-d');
        $this->end_date = $promotion->end_date?->format('Y-m-d');
        $this->is_active = $promotion->is_active;
    }

    public function rules()
    {
        return [
            'code' => ['required', 'string', 'max:50', 'unique:promotions,code,' . $this->promotion->id],
            'description' => ['required', 'string'],
            'discount_type' => ['required', 'in:percentage,fixed'],
            'discount_value' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($this->discount_type === 'percentage' && $value > 100) {
                        $fail('Percentage discount cannot be greater than 100%.');
                    }
                }
            ],
            'usage_limit' => ['required', 'integer', 'min:' . $this->promotion->orders()->count()],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_active' => ['boolean'],
        ];
    }

    public function update()
    {
        $validated = $this->validate();

        $this->promotion->update($validated);

        session()->flash('status', 'Promotion updated successfully.');

        return $this->redirect(route('admin.promotions.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.promotion.update-promotion');
    }
}
