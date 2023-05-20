<?php

namespace App\Interfaces;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

interface CourseInterface
{
	public function get(array $condition);
	public function getAll(array $condition = []);
	public function store(StoreCourseRequest $request);
	public function update(UpdateCourseRequest $request, array $condition);
	public function put(array $request, array $condition);
	public function destroy(array $condition);
	public function datatable($sourcedata = null);
	public function buildDatatableTable();
	public function buildDatatableScript();
}
