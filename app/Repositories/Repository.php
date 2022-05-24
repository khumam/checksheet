<?php

namespace App\Repositories;

use App\Traits\DatatableBuilder;
use Illuminate\Support\Facades\Storage;

abstract class Repository
{
    use DatatableBuilder;

    /**
     * Model name
     *
     * @var mixed
     */
    protected $model;


    /**
     * Fillable column
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Don't update data in specified column
     *
     * @var array
     */
    protected $excludeUpdate = ["password", "remember_token"];

    /**
     * Get one data by spesific condition
     *
     * @param  mixed $condition
     * @return object
     */
    public function get(array $condition)
    {
        if ($this->validateCondition($condition)) {
            return $this->model::where($condition[0], $condition[1], $condition[2] ?? '')->latest()->first();
        }

        return $this->model::where($condition)->latest()->first();
    }

    /**
     * Get all data by spesific condition
     *
     * @param  mixed $condition
     * @return object
     */
    public function getAll(array $condition = [])
    {
        if ($this->validateCondition($condition)) {
            return $this->model::where($condition[0], $condition[1], $condition[2] ?? '')->get();
        }

        return $this->model::where($condition)->get();
    }

    /**
     * Get all data with pagination
     *
     * @param  mixed $totalPage
     * @param  mixed $condition
     * @return void
     */
    public function paginate($totalPage, array $condition)
    {
        if ($this->validateCondition($condition)) {
            return $this->model::where($condition[0], $condition[1], $condition[2] ?? '')->paginate($totalPage);
        }

        return $this->model::where($condition)->paginate($totalPage);
    }

    /**
     * Store data to database
     *
     * @param  mixed $request
     * @return void
     */
    public function store($request)
    {
        return $this->model::create($this->build($request));
    }

    /**
     * Update data to database
     *
     * @param  mixed $request
     * @param  mixed $condition
     * @return void
     */
    public function update($request, array $condition)
    {
        if ($this->validateCondition($condition)) {
            return $this->model::where($condition[0], $condition[1], $condition[2] ?? '')->update($this->build($request, true));
        }

        return $this->model::where($condition)->update($this->build($request, true));
    }

    /**
     * Put data to database
     *
     * @param  mixed $request
     * @param  mixed $condition
     * @return void
     */
    public function put($request, array $condition)
    {
        if ($this->validateCondition($condition)) {
            return $this->model::where($condition[0], $condition[1], $condition[2] ?? '')->update($request);
        }

        return $this->model::where($condition)->update($request);
    }

    /**
     * Destroy data from database
     *
     * @param  mixed $condition
     * @return void
     */
    public function destroy(array $condition)
    {
        if ($this->validateCondition($condition)) {
            return $this->model::where($condition[0], $condition[1], $condition[2] ?? '')->delete();
        }

        return $this->model::where($condition)->delete();
    }

    /**
     * uploadFile
     *
     * @param  mixed $request
     * @param  mixed $name
     * @param  mixed $path
     * @return void
     */
    public function uploadFile($request, string $name, string $path, bool $deleteFirst = false)
    {
        if ($deleteFirst) {
            $this->deleteFile($request->$name);
        }

        return ($request->hasFile($name)) ? $request->file($name)->store($path) : null;
    }

    /**
     * deleteFile
     *
     * @param  mixed $path
     * @return void
     */
    public function deleteFile(string $path)
    {
        return ($path != '') ? Storage::delete($path) : true;
    }

    /**
     * Build database column atribute
     *
     * @param  mixed $request
     * @param  mixed $excludeUpdate
     * @return array
     */
    private function build($request, bool $excludeUpdate = false): array
    {
        $attribute = [];
        foreach ($this->fillable as $fillable) {
            if ($excludeUpdate) {
                if (!in_array($fillable, $this->excludeUpdate)) {
                    $attribute[$fillable] = $request->$fillable;
                }
            } else {
                $attribute[$fillable] = $request->$fillable;
            }
        }

        return $attribute;
    }

    /**
     * Validate Condition that array has key or not
     *
     * @param  mixed $condition
     * @return void
     */
    public function validateCondition(array $condition)
    {
        return ($condition && isset($condition[0])) ? true : false;
    }
}
