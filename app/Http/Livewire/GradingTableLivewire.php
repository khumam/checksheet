<?php

namespace App\Http\Livewire;

use App\Models\Grading;
use Livewire\Component;

class GradingTableLivewire extends Component
{
    public $data = [];
    public $typesId = ['unripe', 'under_ripe', 'ripe', 'over_ripe', 'empty_bunch', 'brondolan'];


    public function mount()
    {
        $gradingData = Grading::latest()->first();
        if ($gradingData) {
            $dataType = json_decode($gradingData->data, true);
            foreach ($this->typesId as $type) {
                $this->data[$type] = $dataType[$type];
            }
        }
    }

    public function render()
    {
        return view('livewire.grading-table-livewire');
    }
}
