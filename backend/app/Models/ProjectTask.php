<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class ProjectTask extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'content',
        'type',
        'status',
        'order'
    ];

    /**
     * Get the status that owns the project_tasks.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class, 'status', 'id');
    }

    /**
     * Get the user that owns the project_tasks.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }

    /**
     * Get the project that owns the project_tasks.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }

    /**
     * Get the created_at attribute.
     *
     * @param  string  $value
     * @return string
     */
    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('D d F');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth('web')->check()) {
                $maxOrder = self::where('status', $model->status)
                    ->where('user_id', auth()->user()->id)
                    ->where('project_id', $model->project_id)
                    ->max('order');
            } else {
                $maxOrder = self::where('status', $model->status)
                    ->where('user_id', 1)
                    ->where('project_id', $model->project_id)
                    ->max('order');
            }
            $model->order = $maxOrder + 1;
        });
    }
}
