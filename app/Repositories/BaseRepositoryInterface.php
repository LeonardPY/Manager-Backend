<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function all(): mixed;

    public function findOrFail($id): mixed;

    public function create(array $data): mixed;

    public function insert(array $data): mixed;

    public function update($id, array $data): mixed;

    public function delete($id): mixed;

    public function first(): mixed;

    public function last(): mixed;

    public function updateOrCreate(array $data, array $attributes): mixed;

    public function firstOrCreate(array $data, array $attributes): mixed;

}
