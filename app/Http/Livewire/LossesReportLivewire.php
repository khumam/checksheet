<?php

namespace App\Http\Livewire;

use App\Models\Loss;
use Livewire\Component;

class LossesReportLivewire extends Component
{
    public $data = [];
    public $reports = [];
    public $items = [
        'Empty Bunch',
        'Fruit Loss in EB',
        'USB',
        'Presscake',
        'Nut',
        'Final Effluent',
        'Total Oil Losses'
    ];

    public function mount()
    {
        $this->data = Loss::latest()->first();
        $this->process();

    }

    public function process()
    {
        if ($this->data) {
            $categories = ['Oil Losses on FFB'];
            $reports = json_decode($this->data->data, true);
            foreach ($reports as $report => $items) {
                if (in_array($report, $categories)) {
                    foreach ($items as $item => $value) {
                        if (in_array($item, $this->items)) {
                            $this->reports[$item] = $value['hasil'];
                        }
                    }
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.losses-report-livewire');
    }
}
