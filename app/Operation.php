<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель сущности `operation`.
 *
 * @property int $id
 * @property int $amount
 * @property int $status
 * @property int $user_id
 * @property string $action_at
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class Operation extends Model
{
    public const STATUS_NEW = 0;
    public const STATUS_CONFIRMED = 1;
    public const STATUS_DECLINED = -1;

    protected $table = 'operation';

//    protected $fillable = ['amount', 'action_at', 'description'];

    protected $guarded = ['user_id', 'status'];
}