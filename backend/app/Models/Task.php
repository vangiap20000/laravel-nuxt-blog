<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'type',
        'status',
        'order'
    ];

    /**
     * Get the status that owns the tasks.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class, 'status', 'id');
    }

    /**
     * Get the user that owns the tasks.
     */
    public function user(): BelongsTo
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
        return Carbon::parse($value)->format('D F');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth('web')->check()) {
                $maxOrder = self::where('status', $model->status)->where('user_id', auth()->user()->id)->max('order');
            } else {
                $maxOrder = self::where('status', $model->status)->where('user_id', 1)->max('order');
            }
            $model->order = $maxOrder + 1;
        });
    }
}
