<?php

namespace App\Livewire\Promotion;

use App\Models\Promotion;
use Livewire\Component;

class PostPromotion extends Component
{
    public $code;
    public $description;
    public $discount_type = 'percentage';
    public $discount_value;
    public $usage_limit;
    public $start_date;
    public $end_date;
    public $is_active = true;

    public function rules()
    {
        return [
            'code' => ['required', 'string', 'max:50', 'unique:promotions,code'],
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
            'usage_limit' => ['required', 'integer', 'min:1'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_active' => ['boolean'],
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        Promotion::create($validated);

        session()->flash('status', 'Promotion created successfully.');

        return $this->redirect(route('admin.promotions.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.promotion.post-promotion');
    }
}
