<?php
/**
 * @author d.ivaschenko
 */

namespace App\Models;

/**
 * Interface ModelInterface
 * @package App\Models
 *
 * @property $id
 * @property $status
 */
interface ModelInterface
{
    public function getAttributes(): array;

    public function fill(array $data): void;
}