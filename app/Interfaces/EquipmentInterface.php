<?php

namespace App\Interfaces;

use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;

interface EquipmentInterface
{
	public function get(array $condition);
	public function getAll(array $condition = []);
	public function store(StoreEquipmentRequest $request);
	public function update(UpdateEquipmentRequest $request, array $condition);
	public function put(array $request, array $condition);
	public function destroy(array $condition);
	public function datatable($sourcedata = null);
	public function buildDatatableTable();
	public function buildDatatableScript();
}
