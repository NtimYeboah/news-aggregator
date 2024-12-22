<?php

namespace App\Source;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SourceManager
{
    /**
     * Configures sources
     *
     * @var array
     */
    public array $config;

    /**
     * Retrieval interval value.
     *
     * @var string
     */
    protected string $retrievalInterval;

    public function __construct()
    {
        $this->config = config('news-sources.sources');
        $this->retrievalInterval = config('news-sources.retrieval_interval_minutes');
    }

    /**
     * Get configured sources.
     *
     * @return Collection
     */
    public function get()
    {
        $sources = collect();

        foreach ($this->config as $sourceKey => $envVars) {
            $sourceClass = '\\App\\Source\\Sources\\'. Str::studly($sourceKey);

            $sources->push(new $sourceClass($envVars));
        }

        return $sources;
    }

    /**
     * Get retrieval interval value.
     *
     * @return string
     */
    public function retrievalInterval()
    {
        return $this->retrievalInterval;
    }
}
