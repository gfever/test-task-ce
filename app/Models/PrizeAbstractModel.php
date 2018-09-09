<?php

namespace App\Models;

use App\Prizes\PrizeInterface;
use App\Prizes\PrizeStatusChangeValidator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Bonus
 * @package App\Models
 *
 * @property int $amount
 * @property int $user_id
 * @property User $user
 * @property string $status
 */
abstract class PrizeAbstractModel extends Model implements PrizeInterface
{
    public const AVAILABLE_STATUSES = [];
    /**
     * @return string
     * @throws \ReflectionException
     */
    public function getType(): string
    {
        return strtolower((new \ReflectionClass($this))->getShortName());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @param string $newStatus
     */
    public function updateStatus(string $newStatus): void
    {
        resolve(PrizeStatusChangeValidator::class)->validate($this->status, $newStatus, static::AVAILABLE_STATUSES);

        $this->processStatus($newStatus);
    }

    /**
     * @param string $status
     */
    protected function processStatus(string $status)
    {
        $this->status = $status;
        $this->save();
    }
}
