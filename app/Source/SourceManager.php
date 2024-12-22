<?php

namespace App\Source;

use Illuminate\Support\Str;

class SourceManager
{
    public array $config;

    protected $retrievalInterval;

    public function __construct()
    {
        $this->config = config('news-sources.sources');
        $this->retrievalInterval = config('news-sources.retrieval_interval_minutes');
    }

    public function get()
    {
        $sources = collect();

        foreach ($this->config as $sourceKey => $envVars) {
            $sourceClass = '\\App\\Source\\Sources\\'. Str::studly($sourceKey);

            $sources->push(new $sourceClass($envVars));
        }

        return $sources;
    }

    public function retrievalInterval()
    {
        return $this->retrievalInterval;
    }
}
