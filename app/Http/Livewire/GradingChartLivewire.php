<?php

namespace App\Http\Livewire;

use App\Models\Grading;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Livewire\Component;

class GradingChartLivewire extends Component
{
    public $types = ['Unripe', 'Underripe', 'Ripe', 'Overripe', 'Empty bunch'];
    public $typesId = ['unripe', 'under_ripe', 'ripe', 'over_ripe', 'empty_bunch'];
    public $colors = ['#f6ad55', '#fc8181', '#90cdf4', '#90cdf4', '#66DA26'];
    public $data = [];


    public function mount()
    {
        $gradingData = Grading::latest()->first();
        if ($gradingData) {
            $dataType = json_decode($gradingData->data, true);
            foreach ($this->typesId as $type) {
                $this->data[] = $dataType[$type];
            }
        }
    }

    public function render()
    {
        return view('livewire.grading-chart-livewire');
    }
}
