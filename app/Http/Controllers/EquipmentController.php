<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Interfaces\EquipmentInterface;
use App\Models\Equipment;
use App\Traits\RedirectNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    use RedirectNotification;

    protected $equipmentInterface;

    function __construct(EquipmentInterface $equipmentInterface) {
        $this->equipmentInterface = $equipmentInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $datatable = $this->equipmentInterface->buildDatatableTable();
        $datatableScript = $this->equipmentInterface->buildDatatableScript();
        return view('equipment.index', compact('datatable', 'datatableScript'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('equipment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEquipmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipmentRequest $request)
    {
        $act = $this->equipmentInterface->store($request);
        return $this->sendRedirectTo($act, 'Berhasil menambahkan equipment baru', 'Gagal menambahkan equipment baru', route('admin.equipment.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function show(string $id): View
    {
        $equipment = $this->equipmentInterface->get(['id' => $id]);
        return view('equipment.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id): View
    {
        $equipment = $this->equipmentInterface->get(['id' => $id]);
        return view('equipment.edit', compact('equipment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEquipmentRequest  $request
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        $act = $this->equipmentInterface->update($request, ['id' => $equipment->id]);
        return $this->sendRedirectTo($act, 'Berhasil menyunting equipment baru', 'Gagal menyunting equipment baru', route('admin.equipment.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $equipment)
    {
        $act = $this->equipmentInterface->destroy(['id' => $equipment->id]);
        return $this->sendRedirectTo($act, 'Berhasil menghapus equipment baru', 'Gagal menghapus equipment baru', route('admin.equipment.index'));
    }

    /**
     * list
     *
     * @param  mixed $request
     * @return void
     */
    public function list(Request $request)
    {
        return ($request->ajax()) ? $this->equipmentInterface->datatable() : null;
    }
}
