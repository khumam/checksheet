<?php

namespace App\Interfaces;

use App\Http\Requests\StoreGradingRequest;
use App\Http\Requests\UpdateGradingRequest;

interface GradingInterface
{
	public function get(array $condition);
	public function getAll(array $condition = []);
	public function store(StoreGradingRequest $request);
	public function update(UpdateGradingRequest $request, array $condition);
	public function put(array $request, array $condition);
	public function destroy(array $condition);
	public function datatable($sourcedata = null);
	public function buildDatatableTable();
	public function buildDatatableScript();
    public function getDataBetween($startMonth, $endMonth);
}
