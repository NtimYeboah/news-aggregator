<?php

namespace App\Actions\Source\Sources;

use App\Actions\Source\Source;

class NewYorkTimes extends Source
{
    protected function url()
    {
        // Update this
        return "{$this->endpoint()}?q={$this->queryParameters->searchTerm()}
            &from={$this->queryParameters->retrievefrom()}
            &to={$this->queryParameters->retrieveTo()}
            &page={$this->queryParameters->page()}";
    }
}
