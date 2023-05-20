<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Interfaces\CourseInterface;
use App\Models\Course;
use App\Traits\RedirectNotification;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use RedirectNotification;

    public $courseInterface;

    public function __construct(CourseInterface $courseInterface)
    {
        $this->courseInterface = $courseInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datatable = $this->courseInterface->buildDatatableTable();
        $datatableScript = $this->courseInterface->buildDatatableScript();
        return view('course.index', compact('datatable', 'datatableScript'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        $request->total_quickshots = 0;
        $request->total_durations = 0;
        $act = $this->courseInterface->store($request);
        return $this->sendRedirectTo($act, 'The new course successfully added', 'Failed to add new course', route('admin.course.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = $this->courseInterface->get(['id' => $id]);
        return view('course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = $this->courseInterface->get(['id' => $id]);
        return view('course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCourseRequest  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseRequest $request, $id)
    {
        $act = $this->courseInterface->update($request, ['id' => $id]);
        return $this->sendRedirectTo($act, 'The course successfully updated', 'Failed to update course', route('admin.course.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $act = $this->courseInterface->destroy(['id' => $id]);
        return $this->sendRedirectTo($act, 'The course successfully deleted', 'Failed to delete course', route('admin.course.index'));
    }

    /**
     * list
     *
     * @param  mixed $request
     * @return void
     */
    public function list(Request $request)
    {
        return ($request->ajax()) ? $this->courseInterface->datatable() : null;
    }
}
