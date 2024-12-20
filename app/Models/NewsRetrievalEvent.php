<?php

namespace App\Models;

use App\Enums\NewsRetrievalEventStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NewsRetrievalEvent extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'status' => NewsRetrievalEventStatus::class,
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public $timestamps = true;

    public function scopeFor(Builder $builder, string $source)
    {
        return $builder->where('source', $source);
    }

    public function attempts()
    {
        return $this->hasMany(NewsRetrievalAttempt::class, 'event_id');
    }

    public function successful()
    {
        return $this->status === NewsRetrievalEventStatus::COMPLETED->value;
    }

    public function unsuccessful()
    {
        return ! $this->successful();
    }

    public function setCompleted()
    {
        $this->status = NewsRetrievalEventStatus::COMPLETED->value;
        $this->completed_at = now();

        $this->save();
    }

    public function setFailed()
    {
        $this->status = NewsRetrievalEventStatus::FAILED->value;
        $this->failed_at = now();

        $this->save();
    }
}
