<?php

namespace App\Actions\Source\Sources;

use App\Actions\Source\Source;

class Guardian extends Source
{
    public function url()
    {
        $url = "{$this->endpoint()}?api-key={$this->apiKey()}";

        if ($searchTerm = $this->queryParameters->searchTerm()) {
            $url = $url . "&q={$searchTerm}";
        }

        if ($retrieveFrom = $this->queryParameters->retrieveFrom()) {
            $url = $url . "&from-date={$retrieveFrom->toDateString()}";
        }

        if ($retrieveTo = $this->queryParameters->retrieveTo()) {
            $url = $url . "&to-date={$retrieveTo->toDateString()}";
        }

        if ($pageSize = $this->queryParameters->pageSize()) {
            $url = $url . "&page={$pageSize}";
        }

        return $url;
    }
}
