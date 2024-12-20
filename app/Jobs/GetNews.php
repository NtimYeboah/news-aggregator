<?php

namespace App\Jobs;

use App\Models\NewsRetrievalAttempt;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Throwable;

class GetNews implements ShouldQueue
{
    use Queueable;

    public const RETRY = 3;

    public const RETRY_WAIT_TIME = 100; // In milliseconds

    /**
     * Create a new job instance.
     */
    public function __construct(public NewsRetrievalAttempt $retrievalAttempt)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->retrievalAttempt->setStarted();

        $response = Http::retry(self::RETRY, self::RETRY_WAIT_TIME)
            ->get($this->retrievalAttempt->getUrl());

        logger(['response' => $response->body()]);

        $response->throwIf($response->failed());

        $this->retrievalAttempt->setCompleted($response);

        //SaveNews::dispatch(NewsDTO::fromArray($response->body()));
    }

    public function failed(?Throwable $exception): void
    {
        $this->retrievalAttempt->setFailed();
    }
}
