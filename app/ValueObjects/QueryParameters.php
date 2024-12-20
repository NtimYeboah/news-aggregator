<?php

namespace App\ValueObjects;

class QueryParameters
{
    private function __construct(private array $parameters)
    {
        
    }

    public static function fromArray(array $parameters)
    {
        return new self($parameters);
    }

    public function retrieveFrom()
    {
        return $this->parameters['retrieve_from'] ?? null;
    }

    public function retrieveTo()
    {
        return $this->parameters['retrieve_to'] ?? null;
    }

    public function searchTerm()
    {
        return $this->parameters['search_term'] ?? null;
    }

    public function sortKey()
    {
        return $this->parameters['sort_key'] ?? null;
    }

    public function pageSize()
    {
        return $this->parameters['page_size'] ?? null;
    }

    public function page()
    {
        return $this->parameters['page'] ?? null;
    }
}
