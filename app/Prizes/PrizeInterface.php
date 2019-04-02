<?php
/**
 * @author d.ivaschenko
 */

namespace App\Prizes;

/**
 * Interface PrizeInterface
 *
 * @package App\Prizes
 *
 * @property int    $id
 * @property int    $user_id
 * @property string $status
 */
interface PrizeInterface
{

    public function getType();

    public function user();

    public function update();

    public function updateStatus(string $status);

}