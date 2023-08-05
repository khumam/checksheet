<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGradingRequest;
use App\Http\Requests\UpdateGradingRequest;
use App\Interfaces\GradingInterface;
use App\Models\Grading;
use App\Traits\RedirectNotification;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class GradingController extends Controller
{
    use RedirectNotification;

    protected $gradingInterface;

    public function __construct(GradingInterface $gradingInterface)
    {
        $this->gradingInterface = $gradingInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year = null, $month = null): View
    {
        $period = ($year == null && $month == null) ? Carbon::parse(Carbon::now())->format('Y-m') : "$year-$month";
        $parameters = $this->_getParameterData();
        $startMonth = ($year == null && $month == null) ? Carbon::now()->startOfMonth() : Carbon::parse("$year-$month")->startOfMonth();
        $endMonth = ($year == null && $month == null) ? Carbon::now()->endOfMonth() : Carbon::parse("$year-$month")->endOfMonth();
        $fullMonth = CarbonPeriod::create($startMonth, '1 day', $endMonth)->toArray();
        $reports = [];
        $data = $this->gradingInterface->getDataBetween($startMonth, $endMonth);

        foreach($data as $item) {
            $reports[Carbon::parse($item->date)->format('Y-m-d')]['id'] = $item->id;
            $reports[Carbon::parse($item->date)->format('Y-m-d')]['data'] = json_decode($item->data, true);
        }

        return view('grading.index', compact('period', 'parameters', 'fullMonth', 'reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {

        $parameters = $this->_getParameterData();
        return view('grading.create', compact('parameters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGradingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGradingRequest $request)
    {
        $data = json_encode([
            'unripe' => $request->unripe,
            'under_ripe' => $request->under_ripe,
            'ripe' => $request->ripe,
            'over_ripe' => $request->over_ripe,
            'empty_bunch' => $request->empty_bunch,
            'tangkai_panjang' => $request->tangkai_panjang,
            'brondolan' => $request->brondolan,
            'kotoran' => $request->kotoran,
            'tbs_sakit' => $request->tbs_sakit,
        ]);
        $request->data = $data;
        $act = $this->gradingInterface->store($request);
        return $this->sendRedirectTo($act, 'Berhasil menambahkan data grading', 'Gagal menambahkan data grading', route('admin.grading.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grading  $grading
     * @return \Illuminate\Http\Response
     */
    public function show(Grading $grading)
    {
        return view('grading.show', compact('grading'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grading  $grading
     * @return \Illuminate\Http\Response
     */
    public function edit(Grading $grading)
    {
        $parameters = $this->_getParameterData();
        $data = json_decode($grading->data, true);
        return view('grading.edit', compact('grading', 'parameters', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGradingRequest  $request
     * @param  \App\Models\Grading  $grading
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGradingRequest $request, Grading $grading)
    {
        $data = json_encode([
            'unripe' => $request->unripe,
            'under_ripe' => $request->under_ripe,
            'ripe' => $request->ripe,
            'over_ripe' => $request->over_ripe,
            'empty_bunch' => $request->empty_bunch,
            'tangkai_panjang' => $request->tangkai_panjang,
            'brondolan' => $request->brondolan,
            'kotoran' => $request->kotoran,
            'tbs_sakit' => $request->tbs_sakit,
        ]);
        $request->data = $data;
        $act = $this->gradingInterface->update($request, ['id' => $grading->id]);
        return $this->sendRedirectTo($act, 'Berhasil mengupdate data grading', 'Gagal mengupdate data grading', route('admin.grading.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grading  $grading
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grading $grading)
    {
        $act = $this->gradingInterface->destroy(['id' => $grading->id]);
        return $this->sendRedirectTo($act, 'Berhasil menghapus data grading', 'Gagal menghapus data grading', route('admin.grading.index'));
    }

    /**
     * list
     *
     * @param  mixed $request
     * @return void
     */
    public function list(Request $request)
    {
        return ($request->ajax()) ? $this->gradingInterface->datatable() : null;
    }

    private function _getParameterData()
    {
        return [
            'unripe' => [
                'name' => 'Unripe',
                'target' => '0%'
            ],
            'under_ripe' => [
                'name' => 'Underripe',
                'target' => 'Max. 5%'
            ],
            'ripe' => [
                'name' => 'Ripe',
                'target' => 'Min. 90%'
            ],
            'over_ripe' => [
                'name' => 'Overripe',
                'target' => 'Max. 5%'
            ],
            'empty_bunch' => [
                'name' => 'Empty bunch',
                'target' => '0%'
            ],
            'tangkai_panjang' => [
                'name' => 'Tangkai panjang',
                'target' => '1%'
            ],
            'brondolan' => [
                'name' => 'Brondolan',
                'target' => '>= 10%',
            ],
            'kotoran' => [
                'name' => 'Kotoran',
                'target' => '0.1(%)'
            ],
            'tbs_sakit' => [
                'name' => 'TBS sakit',
                'target' => '3%'
            ],
        ];
    }
}
