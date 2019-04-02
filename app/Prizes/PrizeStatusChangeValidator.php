<?php
/**
 * Created by PhpStorm.
 * User: fevr
 * Date: 08.09.2018
 * Time: 22:39
 */

namespace App\Prizes;


class PrizeStatusChangeValidator
{

    /**
     * @param string $currentStatus
     * @param string $newStatus
     * @param array  $availableStatuses
     */
    public function validate(?string $currentStatus, string $newStatus, array $availableStatuses): void
    {
        if ($currentStatus === null) {
            return;
        }
        if ($currentStatus === $newStatus) {
            throw new \InvalidArgumentException("Statuses can't be the same {$currentStatus} {$newStatus}", 400);
        }

        if (!\in_array($newStatus, $availableStatuses, true)) {
            throw new \InvalidArgumentException("New status {$newStatus} not available for this prize type", 400);
        }

        $currentStatusIndex = array_search($currentStatus, $availableStatuses, true);
        $newtStatusIndex = array_search($newStatus, $availableStatuses, true);

        if ($currentStatusIndex > $newtStatusIndex) {
            throw new \InvalidArgumentException("New status  {$newStatus} behind current {$currentStatus}", 400);
        }

        if (\count(array_unique([
                $currentStatus,
                $newtStatusIndex,
                Prize::PRIZE_STATUS_CANCELLED,
                Prize::PRIZE_STATUS_ACCEPTED
            ])) === 2
        ) {
            throw new \InvalidArgumentException("New status {$newStatus} and current {$currentStatus} not switchable",
                400);
        }

        if (\count(array_unique([
                $currentStatus,
                $newtStatusIndex,
                Prize::PRIZE_STATUS_WITHDRAWAL,
                Prize::PRIZE_STATUS_CONVERTED
            ])) === 2
        ) {
            throw new \InvalidArgumentException("New status {$newStatus} and current {$currentStatus} not switchable",
                400);
        }
    }


}