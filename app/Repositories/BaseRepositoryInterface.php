<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function all();

    public function findOrFail($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function first(): mixed;

    public function last(): mixed;

    public function updateOrCreate(array $data, array $attributes): mixed;

    public function firstOrCreate(array $data, array $attributes): mixed;

}
