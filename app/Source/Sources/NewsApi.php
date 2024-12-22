<?php

namespace App\Source\Sources;

use App\Source\Source;
use App\ValueObjects\QueryParameters;

class NewsApi extends Source
{
    public function setQueryParameters(array $parameters)
    {
        $defaultParameters = [
            'retrieve_from' => '',
            'retrieve_to' => '',
            'search_term' => 'football',
            'sort_key' => '',
            'page_size' => '100',
            'page' => '',
        ];

        $this->queryParameters = QueryParameters::fromArray(array_merge($defaultParameters, $parameters));
    }

    public function url()
    {
        $url = "{$this->endpoint()}?apiKey={$this->apiKey()}";

        if ($searchTerm = $this->queryParameters->searchTerm()) {
            $url = $url . "&q={$searchTerm}";
        }

        if ($retrieveFrom = $this->queryParameters->retrieveFrom()) {
            $url = $url . "&from={$retrieveFrom->toDateString()}";
        }

        if ($retrieveTo = $this->queryParameters->retrieveTo()) {
            $url = $url . "&to={$retrieveTo->toDateString()}";
        }

        if ($pageSize = $this->queryParameters->pageSize()) {
            $url = $url . "&pageSize={$pageSize}";
        }

        return $url;
    }
}
