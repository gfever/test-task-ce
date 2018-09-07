<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Shipment
 * @package App\Models
 *
 * @property-read integer id
 * @property-read User user
 * @property integer user_id
 * @property string name
 * @property string status
 */
class Shipment extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
