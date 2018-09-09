<?php
/**
 * @author d.ivaschenko
 */

namespace App\Repositories;


use App\Models\ModelInterface;

interface RepositoryInterface
{
    public function create(ModelInterface $model): bool;

    public function updateStatus(ModelInterface $model, string $status): bool;

    public function createNew(string $type, array $data): ModelInterface;

    public function getOneBy(string $name, string $value);
}