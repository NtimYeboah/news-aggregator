<?php

namespace App\Actions;

use App\Actions\Source\Source;
use App\Actions\Source\SourceManager;
use App\Enums\NewsRetrievalAttemptStatus;
use App\Enums\NewsRetrievalEventStatus;
use App\Jobs\GetNews;
use App\Models\NewsRetrievalAttempt;
use App\Models\NewsRetrievalEvent;

class NewsRetrievalHandler
{
    public function __construct(public SourceManager $sources)
    {
        
    }

    public function execute()
    {
        foreach ($this->sources->get() as $source) {
            $this->getNewsFromSource($source);
        }
    }

    protected function getLatestEvent(Source $source)
    {
        $latestNewsRetrievalEvent = NewsRetrievalEvent::for($source->name())->latest()->first();
        
        if (! $latestNewsRetrievalEvent || $latestNewsRetrievalEvent->successful()) {
            $latestNewsRetrievalEvent = NewsRetrievalEvent::create([
                'source' => $source->name(),
                'status' => NewsRetrievalEventStatus::STARTED->value,
                'started_at' => now()->subMinutes($this->sources->retrievalInterval()),
            ]);
        }

        return $latestNewsRetrievalEvent;
    }

    protected function setSourceQueryParameters(Source $source, NewsRetrievalEvent $retrievalEvent)
    {
        $source->setQueryParameters([
            'retrieve_from' => $retrievalEvent->started_at,
        ]);
    }

    protected function getNewsFromSource(Source $source)
    {
        $latestNewsRetrievalEvent = $this->getLatestEvent($source);

        $this->setSourceQueryParameters($source, $latestNewsRetrievalEvent);

        $retrievalAttempt = NewsRetrievalAttempt::create([
            'event_id' => $latestNewsRetrievalEvent->getKey(),
            'retrieved_from' => $latestNewsRetrievalEvent->started_at,
            'source' => $source->name(),
            'status' => NewsRetrievalAttemptStatus::NOT_STARTED->value,
            'url' => $source->url(),
        ]);

        GetNews::dispatch($retrievalAttempt);
    }
}
