<?php

namespace App\Models;

use App\Enums\NewsRetrievalAttemptStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Response;

class NewsRetrievalAttempt extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'status' => NewsRetrievalAttemptStatus::class,
        'retrieve_from' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public $timestamps = true;

    public function event()
    {
        return $this->belongsTo(NewsRetrievalEvent::class, 'event_id');
    }

    public function successful()
    {
        return $this->status === NewsRetrievalAttemptStatus::COMPLETED->value;
    }

    public function unsuccessful()
    {
        return ! $this->successful();
    }

    public function setStarted()
    {
        $this->status = NewsRetrievalAttemptStatus::STARTED->value;
        $this->started_at = now();

        $this->save();
    }

    public function setCompleted(Response $response)
    {
        $this->status = NewsRetrievalAttemptStatus::COMPLETED->value;
        $this->response_code = $response->status();
        $this->completed_at = now();

        $this->save();

        $this->event->setCompleted();
    }

    public function setFailed()
    {
        $this->status = NewsRetrievalAttemptStatus::FAILED->value;
        $this->save();

        $this->event->setFailed();
    }

    // Get this from the source
    // Make this an accessor (Accessor and Modifiers)
    public function getUrl()
    {
        return "{$this->url}";
    }
}
