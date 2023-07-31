<?php

namespace App\Interfaces;

use App\Http\Requests\StoreCheckSheetRequest;
use App\Http\Requests\UpdateCheckSheetRequest;

interface CheckSheetInterface
{
	public function get(array $condition);
	public function getAll(array $condition = []);
	public function store(StoreCheckSheetRequest $request);
	public function update(UpdateCheckSheetRequest $request, array $condition);
	public function put(array $request, array $condition);
	public function destroy(array $condition);
	public function datatable($sourcedata = null);
	public function buildDatatableTable();
	public function buildDatatableScript();

    public function updateTimeRow($checkSheetId, $equipmentId, $descId, $time, $value);
    public function updateKeterangan($checkSheetId, $equipmentId, $descId, $value);
}
