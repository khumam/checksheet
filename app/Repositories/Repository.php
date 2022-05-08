<?php

namespace App\Repositories;

abstract class Repository
{
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
    protected $excludeUpdate = [];

    /**
     * Get one data by spesific condition
     *
     * @param  mixed $condition
     * @return object
     */
    public function get(array $condition)
    {
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
        return $this->model::where($condition)->get();
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
        return $this->model::where($condition)->update($this->build($request, true));
    }

    /**
     * Destroy data from database
     *
     * @param  mixed $condition
     * @return void
     */
    public function destroy(array $condition)
    {
        return $this->model::where($condition)->destroy();
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
}
