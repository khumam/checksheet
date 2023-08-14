<?php

namespace App\Http\Livewire;

use App\Models\CheckSheet;
use Livewire\Component;

class ScoringLivewire extends Component
{
    public $scorings = [
        'Sterilizer' => [
            'value' => 0,
            'identifier' => 'Sterilizer',
            'exludes' => ['Sequencing time', 'Total lama waktu perebusan'],
            'total' => 0
        ],
        'Press' => [
            'value' => 0,
            'identifier' => 'Press',
            'exludes' => [],
            'total' => 0
        ],
        'Klarifikasi' => [
            'value' => 0,
            'identifier' => 'Klarifikasi',
            'exludes' => [],
            'total' => 0
        ],
        'Boiler' => [
            'value' => 0,
            'identifier' => 'Boiler',
            'exludes' => [],
            'total' => 0
        ],
        'Engine' => [
            'value' => 0,
            'identifier' => 'Turbin',
            'exludes' => [],
            'total' => 0
        ]
    ];
    public $serializeData = [];
    public $descs = null;

    public $data = null;
    public $reports = null;

    public function mount()
    {
        $this->data = CheckSheet::latest()->first();
        if ($this->data) {
            $this->reports = json_decode($this->data->reports, true);
            $this->descs = json_decode($this->data->descs, true);
            $this->serialize();
            $this->countNotStandard();
            $this->countScoring();
        }
    }

    public function serialize()
    {
        foreach($this->descs as $descs => $equipments) {
            foreach($equipments as $equipment) {
                $descId = $equipment['id'];
                $equipmentId = $equipment['equipment_id'];
                $this->serializeData[$descs][$equipment['desc']] = [
                    'standard' => $equipment['standard'],
                    'values' => $this->reports[$equipmentId][$descId],
                    'totalStandard' => 0,
                    'averageStandard' => 0,
                    'percentageStandard' => 0,
                    'scoreStandard' => 0
                ];
            }
        }
    }

    public function countScoring()
    {
        foreach ($this->scorings as $item => $items) {
            foreach ($this->serializeData as $serialize => $values) {
                if (str_contains($serialize, $items['identifier'])) {
                    foreach ($values as $value) {
                        if (!str_contains(implode(',', $items['exludes']), array_keys($value)[0])) {
                            $this->scorings[$item]['value'] += $value['scoreStandard'];
                            $this->scorings[$item]['total'] += 1;
                        }
                    }
                } else {
                    continue;
                }
            }
        }
    }

    public function countNotStandard() {
        foreach($this->serializeData as $equipment => $descs) {
            foreach($descs as $desc) {
                $standard = $this->separateStandard($desc['standard']);
                $totalStandard = $this->countTotalStandard($desc['values'], $standard);
                $this->serializeData[$equipment][array_keys($descs)[0]]['totalStandard'] = $totalStandard;
                $totalAverageStandard = $this->countTotalAverageStandard($desc['values'], $totalStandard);
                $this->serializeData[$equipment][array_keys($descs)[0]]['averageStandard'] = $totalAverageStandard;
                $averageStandard = $totalAverageStandard * 100;
                $this->serializeData[$equipment][array_keys($descs)[0]]['percentageStandard'] = $averageStandard;
                $this->serializeData[$equipment][array_keys($descs)[0]]['scoreStandard'] = 100 - $averageStandard;
            }
        }
    }

    public function countTotalStandard($values, $standard) {
        $count = 0;
        foreach ($values as $data => $times) {
            foreach ($times as $time => $value) {
                if ($value < $standard['min'] || $value > $standard['max']) {
                    $count++;
                }
            }
        }
        return $count;
    }

    public function countTotalAverageStandard($values, $standard) {
        $count = 0;
        foreach ($values as $data => $times) {
            foreach ($times as $time => $value) {
                if ($value > 0) {
                    $count++;
                }
            }
        }
        return $count > 0 ? $standard / $count : 0;
    }

    public function separateStandard($standard) {
        if (str_contains($standard, '-')) {
            return [
                'min' => explode('-', $standard)[0],
                'max' => explode('-', $standard)[1],
            ];
        } else if (str_contains($standard, 'max')) {
            return [
                'min' => 0,
                'max' => trim(str_replace('max', '', $standard)),
            ];
        } else if (str_contains($standard, '>')) {
            return [
                'min' => 0,
                'max' => trim(str_replace('>', '', $standard)),
            ];
        }
        return [
            'min' => 0,
            'max' => $standard
        ];
    }

    public function render()
    {
        return view('livewire.scoring-livewire');
    }
}
