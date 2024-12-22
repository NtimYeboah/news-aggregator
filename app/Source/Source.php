<?php

namespace App\Source;

use App\ValueObjects\Credentials;
use App\ValueObjects\QueryParameters;
use Illuminate\Support\Str;

abstract class Source
{
    protected Credentials $credentials;

    protected QueryParameters $queryParameters;

    public function __construct(array $envVars)
    {
        $this->credentials = Credentials::fromArray($envVars);
    }

    public abstract function url();

    public function name(): string
    {
        return $this->key();
    }

    public function endpoint(): string
    {
        return $this->credentials->endpoint();
    }

    public function apiKey(): string
    {
        return $this->credentials->apiKey();
    }

    protected function key(): string
    {
        $qualifiedClassName = get_called_class();

        $names = collect(explode('\\', $qualifiedClassName));

        return Str::snake($names->last(), '-');
    }

    public function setQueryParameters(array $parameters)
    {
        $defaultParameters = [
            'retrieve_from' => '',
            'retrieve_to' => '',
            'search_term' => '',
            'sort_key' => '',
            'page_size' => '',
            'page' => '',
        ];

        $this->queryParameters = QueryParameters::fromArray(array_merge($defaultParameters, $parameters));
    }
}
