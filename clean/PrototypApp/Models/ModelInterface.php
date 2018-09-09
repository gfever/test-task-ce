<?php
/**
 * @author d.ivaschenko
 */

namespace PrototypApp\Models;

/**
 * Interface ModelInterface
 * @package PrototypApp\Models
 *
 * @property $id
 * @property $status
 */
interface ModelInterface
{
    public function getAttributes(): array;

    public function fill(array $data): void;
}