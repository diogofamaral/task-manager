<?php

namespace App\Models;

use App\Enum\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Task
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property string $status
 * @property string $priority
 * @property \Illuminate\Support\Carbon|null $deadline_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task ofUser(\App\Models\User $user)
 *
 */
class Task extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string[] */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
        'priority',
        'deadline_at',
        'completed_at'
    ];

    /** @var string[] */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deadline_at' => 'datetime:Y-m-d',
        'completed_at' => 'datetime',
        'status' => TaskStatus::class,
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Filter query by a given user
     *
     * @param Builder $builder
     * @param User $user
     */
    public function scopeOfUser(Builder $builder, User $user) : void
    {
        $builder->where('user_id', '=', $user->id);
    }
}
