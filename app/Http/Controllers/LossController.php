<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLossRequest;
use App\Http\Requests\UpdateLossRequest;
use App\Interfaces\LossInterface;
use App\Models\Loss;
use App\Traits\RedirectNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LossController extends Controller
{
    use RedirectNotification;

    protected $lossInterface;

    public function __construct(LossInterface $lossInterface)
    {
        $this->lossInterface = $lossInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $datatable = $this->lossInterface->buildDatatableTable();
        $datatableScript = $this->lossInterface->buildDatatableScript();
        return view('loss.index', compact('datatable', 'datatableScript'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('loss.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLossRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLossRequest $request)
    {
        $request->data = json_encode($this->_getDetailData());
        $act = $this->lossInterface->store($request);
        return $this->sendRedirectTo($act, 'Berhasil menambahkan laporan losses baru', 'Gagal menambahkan laporan losses baru', route('admin.loss.show', $act->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loss  $loss
     * @return \Illuminate\Http\Response
     */
    public function show(Loss $loss): View
    {
        $reports = json_decode($loss->data, true);
        return view('loss.show', compact('loss', 'reports'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loss  $loss
     * @return \Illuminate\Http\Response
     */
    public function edit(Loss $loss): View
    {
        return view('loss.edit', compact('loss'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLossRequest  $request
     * @param  \App\Models\Loss  $loss
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLossRequest $request, Loss $loss)
    {
        $act = $this->lossInterface->update($request, ['id' => $loss->id]);
        return $this->sendRedirectTo($act, 'Berhasil menyunting laporan losses baru', 'Gagal menyunting laporan losses baru', route('admin.loss.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loss  $loss
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loss $loss)
    {
        $act = $this->lossInterface->destroy(['id' => $loss->id]);
        return $this->sendRedirectTo($act, 'Berhasil menghapus laporan losses', 'Gagal menghapus laporan losses', route('admin.loss.index'));
    }

    /**
     * list
     *
     * @param  mixed $request
     * @return void
     */
    public function list(Request $request)
    {
        return ($request->ajax()) ? $this->lossInterface->datatable() : null;
    }

    /**
     * updateTimeRow
     *
     * @param  mixed $request
     * @return void
     */
    public function updateRow(Request $request): Response
    {
        if ($request->ajax()) {
            $detail = $request->detail;
            $item = $request->item;
            $name = $request->name;
            $value = $request->value;
            $id = $request->id;

            $act = $this->lossInterface->updateRow($id, $detail, $item, $name, $value);
            return $act ? response(200) : response(400);
        }

        return response(401);
    }

    private function _getDetailData()
    {
        $data = [
            'Oil Losses on FFB' => [
                'Empty Bunch' => [
                    'standard_losses' => '0.37%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'Fruit Loss in EB' => [
                    'standard_losses' => '0.02%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'USB' => [
                    'standard_losses' => '0.03%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'Presscake' => [
                    'standard_losses' => '0.55%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'Nut' => [
                    'standard_losses' => '0.08%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'Final Effluent' => [
                    'standard_losses' => '0.55%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'Sludge Centrifuge' => [
                    'standard_losses' => '0.40%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'Sludge HSS' => [
                    'standard_losses' => '0.40%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'Condensate' => [
                    'standard_losses' => '0.15%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'Total Oil Losses' => [
                    'standard_losses' => '1.60%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ]
            ],
            'Kernel Losses on FFB' => [
                'Fruit Loss in EB' => [
                    'standard_losses' => '0.01%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'USB' => [
                    'standard_losses' => '0.02%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'Fiber Cyclone' => [
                    'standard_losses' => '0.15%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'Claybath Shell' => [
                    'standard_losses' => '0.05%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'LTDS Shell' => [
                    'standard_losses' => '0.15%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'Total Kernel Losses' => [
                    'standard_losses' => '0.38%',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
            ],
            'Mill Operations' => [
                'TBS Proses' => [
                    'standard_losses' => '',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'CPO Produksi' => [
                    'standard_losses' => '',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'Kernel Produksi' => [
                    'standard_losses' => '',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'Jam Olah' => [
                    'standard_losses' => '',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
            ],
            'Mill Profit' => [
                'OER' => [
                    'standard_losses' => '>24.00',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'KER' => [
                    'standard_losses' => '>4.75',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
            ],
            'Mill Capacity' => [
                'Mill Throughput' => [
                    'standard_losses' => '60.00',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                'Press Throughput' => [
                    'standard_losses' => '15.00',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
            ],
            'Final Effluent' => [
                'Volume' => [
                    'standard_losses' => '',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],
                '%/FFB' => [
                    'standard_losses' => '55.00',
                    'o/wm' => '',
                    'mass_balance' => '',
                    'hasil' => ''
                ],

            ]

        ];

        return $data;
    }
}
