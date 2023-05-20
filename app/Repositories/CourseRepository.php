<?php

namespace App\Repositories;

use App\Interfaces\CourseInterface;
use App\Models\Course;
use App\Traits\RedirectNotification;

class CourseRepository extends Repository implements CourseInterface
{
    use RedirectNotification;

    public function __construct()
    {
        $this->model = new Course();
        $this->fillable = $this->model->getFillable();
        $this->excludeUpdate = ['total_quickshots', 'total_durations'];
        $this->datatableSourceData = $this->getAll();
        $this->datatableRoute = "admin.course";
        $this->datatableHeader = ['Course name' => 'name'];
    }

    public function store($request)
    {
        $request->type = $request->banner->getClientOriginalExtension();
        $request->banner = $this->uploadFile($request, 'banner', 'public/course');
        return $this->model::create($this->build($request));
    }

    public function update($request, array $condition)
    {
        if ($request->hasFile('banner')) {
            $request->type = $request->banner->getClientOriginalExtension();
            $request->banner = $this->uploadFile($request, 'banner', 'public/course', true);
        } else {
            $asset = $this->get($condition);
            $request->banner = $asset->banner;
        }
        return $this->model::where($condition)->update($this->build($request, true));
    }
}
