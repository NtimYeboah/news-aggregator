<?php

namespace App\Actions\Source\Sources;

use App\Actions\Source\Source;

class NewsApi extends Source
{
    public function url()
    {
        $url = "{$this->endpoint()}?apiKey={$this->apiKey()}";

        if ($searchTerm = $this->queryParameters->searchTerm()) {
            $url = $url . "&q={$searchTerm}";
        }

        if ($retrieveFrom = $this->queryParameters->retrieveFrom()) {
            $url = $url . "&from={$retrieveFrom}";
        }

        if ($retrieveTo = $this->queryParameters->retrieveTo()) {
            $url = $url . "&to={$retrieveTo}";
        }

        if ($pageSize = $this->queryParameters->pageSize()) {
            $url = $url . "&page={$pageSize}";
        }

        return $url;
    }
}
