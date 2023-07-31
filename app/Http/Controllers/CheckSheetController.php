<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCheckSheetRequest;
use App\Http\Requests\UpdateCheckSheetRequest;
use App\Interfaces\CheckSheetInterface;
use App\Interfaces\EquipmentInterface;
use App\Models\CheckSheet;
use App\Traits\RedirectNotification;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class ChecksheetController extends Controller
{
    use RedirectNotification;

    protected $checkSheetInterface;
    protected $equipmentInterface;

    function __construct(CheckSheetInterface $checkSheetInterface, EquipmentInterface $equipmentInterface)
    {
        $this->checkSheetInterface = $checkSheetInterface;
        $this->equipmentInterface = $equipmentInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $datatable = $this->checkSheetInterface->buildDatatableTable();
        $datatableScript = $this->checkSheetInterface->buildDatatableScript();
        return view('checksheet.index', compact('datatable', 'datatableScript'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('checksheet.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCheckSheetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCheckSheetRequest $request)
    {
        $equipments = $this->equipmentInterface->getAll();
        $equipmentData = [];
        $periodData = [];
        $reports = [];

        $periodsOne = CarbonPeriod::create('08:00', '2 hours', '23:00')->toArray();
        $periodsTwo = CarbonPeriod::create('00:00', '2 hours', '06:00')->toArray();
        $periods = array_merge(iterator_to_array($periodsOne), iterator_to_array($periodsTwo));
        foreach ($periods as $period) {
            $periodData[] = $period->format('H:i');
        }

        foreach($equipments as $equipment) {
            $equipmentData[$equipment->name] = [];
            $reports[$equipment->id] = [];
            foreach ($equipment->descriptions as $equipmentDesc) {
                $equipmentData[$equipment->name][] = [
                    'equipment_id' => $equipment->id,
                    'id' => $equipmentDesc->id,
                    'desc' => $equipmentDesc->desc,
                    'satuan' => $equipmentDesc->satuan,
                    'standard' => $equipmentDesc->standard,
                    'rata' => '',
                    'keterangan' => ''
                ];
                $reports[$equipment->id][$equipmentDesc->id] = [];
                foreach ($periodData as $periode) {
                    $reports[$equipment->id][$equipmentDesc->id][] = [$periode => null];
                }
            }
        }

        $request->descs = json_encode($equipmentData);
        $request->reports = json_encode($reports);
        $request->validation = '';

        $act = $this->checkSheetInterface->store($request);
        return $this->sendRedirectTo($act, 'Berhasil menambahkan laporan check sheet', 'Gagal menambahkan laporan check sheet', route('admin.checksheet.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CheckSheet  $checksheet
     * @return \Illuminate\Http\Response
     */
    public function show(string $id): View
    {
        $periodData = [];

        $periodsOne = CarbonPeriod::create('08:00', '2 hours', '23:00')->toArray();
        $periodsTwo = CarbonPeriod::create('00:00', '2 hours', '06:00')->toArray();
        $periods = array_merge(iterator_to_array($periodsOne), iterator_to_array($periodsTwo));
        foreach ($periods as $period) {
            $periodData[] = $period->format('H:i');
        }

        $checksheet = $this->checkSheetInterface->get(['id' => $id]);
        return view('checksheet.show', compact('checksheet', 'periodData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CheckSheet  $checksheet
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id): View
    {
        $checksheet = $this->checkSheetInterface->get(['id' => $id]);
        return view('checksheet.edit', compact('checksheet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCheckSheetRequest  $request
     * @param  \App\Models\CheckSheet  $checksheet
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCheckSheetRequest $request, CheckSheet $checksheet)
    {
        $act = $this->checkSheetInterface->update($request, ['id' => $checksheet->id]);
        return $this->sendRedirectTo($act, 'Berhasil menyunting laporan check sheet', 'Gagal menyunting laporan check sheet', route('admin.checksheet.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CheckSheet  $checksheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(CheckSheet $checksheet)
    {
        $act = $this->checkSheetInterface->destroy(['id' => $checksheet->id]);
        return $this->sendRedirectTo($act, 'Berhasil menghapus laporan check sheet', 'Gagal menghapus laporan check sheet', route('admin.checksheet.index'));
    }

    /**
     * list
     *
     * @param  mixed $request
     * @return void
     */
    public function list(Request $request)
    {
        return ($request->ajax()) ? $this->checkSheetInterface->datatable() : null;
    }

    /**
     * updateTimeRow
     *
     * @param  mixed $request
     * @return void
     */
    public function updateTimeRow(Request $request): Response
    {
        if ($request->ajax()) {
            $equipmentId = $request->equipment_id;
            $descId = $request->desc_id;
            $value = $request->value;
            $checkSheetId = $request->checksheet_id;
            $time = $request->time;

            $act = $this->checkSheetInterface->updateTimeRow($checkSheetId, $equipmentId, $descId, $time, $value);
            return $act ? response(200) : response(400);
        }

        return response(401);
    }

    public function updateKeterangan(Request $request): Response
    {
        if ($request->ajax()) {
            $equipmentId = $request->equipment_id;
            $descId = $request->desc_id;
            $value = $request->value;
            $checkSheetId = $request->checksheet_id;

            $act = $this->checkSheetInterface->updateKeterangan($checkSheetId, $equipmentId, $descId, $value);
            return $act ? response(200) : response(400);
        }

        return response(401);
    }
}
