<?php

namespace App\Actions;

use App\Actions\Source\Source;
use App\Actions\Source\SourceManager;
use App\Enums\NewsRetrievalAttemptStatus;
use App\Enums\NewsRetrievalEventStatus;
use App\Jobs\GetNews;
use App\Models\NewsRetrievalAttempt;
use App\Models\NewsRetrievalEvent;
use App\ValueObjects\QueryParameters;

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
                'started_at' => now()->subMinutes($this->sources->retrievalInterval())->toDateString(),
            ]);
        }

        return $latestNewsRetrievalEvent;
    }

    protected function setSourceQueryParameters(Source $source, NewsRetrievalEvent $retrievalEvent, $parameters = [])
    {
        $queryParameters = QueryParameters::fromArray(array_merge([
            'retrieve_from' => $retrievalEvent->started_at,
            'retrieve_to' => '',
            'search_term' => 'football',
            'sort_key' => '',
            'page_size' => '',
            'page' => '',
        ], $parameters));

        $source->setQueryParameters($queryParameters);
    }

    protected function getNewsFromSource(Source $source)
    {
        $latestNewsRetrievalEvent = $this->getLatestEvent($source);

        $this->setSourceQueryParameters($source, $latestNewsRetrievalEvent);

        $retrievalAttempt = NewsRetrievalAttempt::create([
            'event_id' => $latestNewsRetrievalEvent->getKey(),
            'retrieved_from' => $latestNewsRetrievalEvent->started_at,
            'status' => NewsRetrievalAttemptStatus::NOT_STARTED->value,
            'url' => $source->url(),
        ]);

        GetNews::dispatch($retrievalAttempt);
    }
}
