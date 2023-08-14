<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ScoringLivewire extends Component
{
    public $scorings = [
        'Sterilizer' => 0,
        'Press' => 0,
        'Klarifikasi' => 0,
        'Boiler' => 0,
        'Engine' => 0
    ];

    public function render()
    {
        return view('livewire.scoring-livewire');
    }
}
