<?php

namespace App\Interfaces;

use App\Http\Requests\StoreLossRequest;
use App\Http\Requests\UpdateLossRequest;

interface LossInterface
{
	public function get(array $condition);
	public function getAll(array $condition = []);
	public function store(StoreLossRequest $request);
	public function update(UpdateLossRequest $request, array $condition);
	public function put(array $request, array $condition);
	public function destroy(array $condition);
	public function datatable($sourcedata = null);
	public function buildDatatableTable();
	public function buildDatatableScript();
    public function updateRow($id, $detail, $item, $name, $value);
}
