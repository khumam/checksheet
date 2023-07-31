<?php

namespace App\Repositories;

use App\Interfaces\CheckSheetInterface;
use App\Models\CheckSheet;
use App\Traits\RedirectNotification;

class CheckSheetRepository extends Repository implements CheckSheetInterface
{
    use RedirectNotification;

    public function __construct()
    {
        $this->model = new CheckSheet();
        $this->fillable = $this->model->getFillable();
        $this->datatableSourceData = $this->getAll();
        $this->datatableRoute = 'admin.checksheet';
        $this->datatableHeader = ['Tanggal' => 'date', 'Lokasi' => 'location'];
    }

    /**
     * updateTimeRow
     *
     * @param  mixed $checkSheetId
     * @param  mixed $equipmentId
     * @param  mixed $descId
     * @param  mixed $time
     * @param  mixed $value
     * @return void
     */
    public function updateTimeRow($checkSheetId, $equipmentId, $descId, $time, $value)
    {
        $checksheet = $this->model::where('id', $checkSheetId)->first();
        $reports = json_decode($checksheet->reports, true);
        foreach ($reports[$equipmentId][$descId] as $index => $timedetail) {
            if (array_keys($timedetail)[0] === $time) {
                $reports[$equipmentId][$descId][$index][$time] = $value;
            }
        }
        $newReports = json_encode($reports);

        return $this->model::where('id', $checkSheetId)->update(
            [
                'reports' => $newReports
            ]
        );
    }

    public function updateKeterangan($checkSheetId, $equipmentId, $descId, $value)
    {
        $checksheet = $this->model::where('id', $checkSheetId)->first();
        $descs = json_decode($checksheet->descs, true);
        foreach($descs as $descname => $descitem) {
            foreach($descitem as $key => $item) {
                if ($item['equipment_id'] == $equipmentId && $item['id'] == $descId) {
                    $descs[$descname][$key]['keterangan'] = $value;
                }
            }
        }
        $newDesc = json_encode($descs);
        return $this->model::where('id', $checkSheetId)->update(
            [
                'descs' => $newDesc
            ]
        );
    }
}
