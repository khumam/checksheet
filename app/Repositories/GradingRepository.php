<?php

namespace App\Repositories;

use App\Interfaces\GradingInterface;
use App\Models\Grading;
use App\Traits\RedirectNotification;

class GradingRepository extends Repository implements GradingInterface
{
    use RedirectNotification;

    public function __construct()
    {
        $this->model = new Grading();
        $this->fillable = $this->model->getFillable();
        $this->datatableSourceData = $this->getAll();
        $this->datatableRoute = 'admin.grading';
        $this->datatableHeader = ['Tanggal' => 'date', 'Data' => 'data'];
    }

    public function getDataBetween($startMonth, $endMonth)
    {
        return Grading::whereBetween('date', [$startMonth, $endMonth])->get();
    }
}
