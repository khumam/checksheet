<?php

namespace App\Repositories;

use App\Interfaces\LossInterface;
use App\Models\Loss;
use App\Traits\RedirectNotification;
use Illuminate\Support\Carbon;

class LossRepository extends Repository implements LossInterface
{
    use RedirectNotification;

    public function __construct()
    {
        $this->model = new Loss();
        $this->fillable = $this->model->getFillable();
        $this->datatableSourceData = $this->model->latest()->get();
        $this->datatableHeader = ['Tanggal' => 'date'];
        $this->datatableRoute = 'admin.loss';
        $this->excludeUpdate = ['data'];
        $this->datatableColumns = [
            'date' => function ($data) {
                return Carbon::parse($data->date)->locale('ID')->format('d F Y');
            }
        ];
    }

    public function updateRow($id, $detail, $item, $name, $value)
    {
        $lossData = $this->get(['id' => $id]);
        $reportData = json_decode($lossData->data, true);
        $reportData[$detail][$item][$name] = $value;
        $jsonReport = json_encode($reportData);
        return $this->model->where('id', $id)->update([
            'data' => $jsonReport
        ]);
    }
}
