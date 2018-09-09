<?php
/**
 * @author d.ivaschenko
 */

namespace App\Models;


abstract class Model implements ModelInterface
{
    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return get_object_vars($this);
    }

    /**
     * @param array $data
     */
    public function fill(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}