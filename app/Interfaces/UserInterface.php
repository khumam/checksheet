<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UserInterface
{
    public function get(array $condition);
    public function getAll(array $condition = []);
    public function store($request);
    public function update($request, array $condition);
    public function destroy(array $condition);
    public function beAdmin(Request $request);
}
