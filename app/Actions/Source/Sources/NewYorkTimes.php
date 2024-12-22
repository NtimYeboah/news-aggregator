<?php

namespace App\Actions\Source\Sources;

use App\Actions\Source\Source;
use App\ValueObjects\QueryParameters;

class NewYorkTimes extends Source
{
    public function setQueryParameters(array $parameters)
    {
        $defaultParameters = [
            'retrieve_from' => '',
            'retrieve_to' => '',
            'search_term' => 'politics',
            'sort_key' => '',
            'page_size' => '',
            'page' => '',
        ];

        $this->queryParameters = QueryParameters::fromArray(array_merge($defaultParameters, $parameters));
    }

    public function url()
    {
        $url = "{$this->endpoint()}?api-key={$this->apiKey()}";

        if ($searchTerm = $this->queryParameters->searchTerm()) {
            $url = $url . "&q={$searchTerm}";
        }

        if ($retrieveFrom = $this->queryParameters->retrieveFrom()) {
            $url = $url . "&begin_date={$retrieveFrom->format('Ymd')}";
        }

        if ($retrieveTo = $this->queryParameters->retrieveTo()) {
            $url = $url . "&end_date={$retrieveTo->format('Ymd')}";
        }

        if ($pageSize = $this->queryParameters->pageSize()) {
            $url = $url . "&pageSize={$pageSize}";
        }

        return $url;
    }
}
