<?php

namespace App\Repositories;

use App\Interfaces\EquipmentInterface;
use App\Models\Equipment;
use App\Models\EquipmentDescription;
use App\Traits\RedirectNotification;
use DB;

class EquipmentRepository extends Repository implements EquipmentInterface
{
    use RedirectNotification;

    public function __construct()
    {
        $this->model = new Equipment();
        $this->fillable = $this->model->getFillable();
        $this->datatableSourceData = $this->getAll();
        $this->datatableRoute = 'admin.equipment';
        $this->datatableHeader = ['Nama' => 'name'];
    }

    /**
     * Get one data by spesific condition
     *
     * @param  mixed $condition
     * @return object
     */
    public function get(array $condition)
    {
        if ($this->validateCondition($condition)) {
            return $this->model::where($condition[0], $condition[1], $condition[2] ?? '')->with('descriptions')->latest()->first();
        }

        return $this->model::where($condition)->with('descriptions')->latest()->first();
    }

    /**
     * Store data to database
     *
     * @param  mixed $request
     * @return void
     */
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $equipment = $this->model::create(['name' => $request->name]);
            for ($index = 0, $total = count($request->desc); $index < $total; $index++) {
                EquipmentDescription::create(
                    [
                        'equipment_id' => $equipment->id,
                        'desc' => $request->desc[$index],
                        'satuan' => $request->satuan[$index],
                        'standard' => $request->standard[$index],
                    ]
                );
            }
            DB::commit();
            return $equipment;
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    /**
     * Update data to database
     *
     * @param  mixed $request
     * @param  mixed $condition
     * @return void
     */
    public function update($request, array $condition)
    {
        DB::beginTransaction();
        try {
            EquipmentDescription::where('equipment_id', $condition['id'])->delete();
            if ($this->validateCondition($condition)) {
                $equipment = $this->model::where($condition[0], $condition[1], $condition[2] ?? '')->update($this->build($request, true));
                for ($index = 0, $total = count($request->desc); $index < $total; $index++) {
                    EquipmentDescription::create(
                        [
                            'equipment_id' => $condition['id'],
                            'desc' => $request->desc[$index],
                            'satuan' => $request->satuan[$index],
                            'standard' => $request->standard[$index],
                        ]
                    );
                }
                DB::commit();
                return $equipment;
            }

            $equipment = $this->model::where($condition)->update($this->build($request, true));
            for ($index = 0, $total = count($request->desc); $index < $total; $index++) {
                EquipmentDescription::create(
                    [
                        'equipment_id' => $condition['id'],
                        'desc' => $request->desc[$index],
                        'satuan' => $request->satuan[$index],
                        'standard' => $request->standard[$index],
                    ]
                );
            }
            DB::commit();
            return $equipment;
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }
}
