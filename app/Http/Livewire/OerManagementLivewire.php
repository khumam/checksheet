<?php

namespace App\Http\Livewire;

use App\Models\Loss;
use Livewire\Component;

class OerManagementLivewire extends Component
{
    public $category = 'Mill Profit';
    public $subCategory = 'OER';
    public $data = null;
    public $report = null;
    public $value = 0;
    public $formHide = true;

    public function mount()
    {
        $this->data = Loss::latest()->first();
        if ($this->data) {
            $this->report = json_decode($this->data->data, true);
            $this->value = $this->report[$this->category][$this->subCategory]['hasil'];
        }
    }

    public function update()
    {
        $report = $this->report;
        $report[$this->category][$this->subCategory]['hasil'] = $this->value;
        $encodedReport = json_encode($report);
        $update = Loss::where('id', $this->data->id)->update([
            'data' => $encodedReport
        ]);
        if ($update) {
            $this->formHide = true;
        }
    }

    public function hideOrShowForm()
    {
        $this->formHide = !$this->formHide;
    }

    public function render()
    {
        return view('livewire.oer-management-livewire');
    }
}
