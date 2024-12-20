<?php

namespace App\ValueObjects;

use RuntimeException;

class Credentials
{
    private function __construct(private array $credentials)
    {
        // Throw exception when api_key and endpoint keys doesn't exist in array
        if ($credentials['api_key'] === '') {
            throw new RuntimeException('API Key cannot be empty.');
        }

        if ($credentials['endpoint'] === '') {
            throw new RuntimeException('Endpoint cannot be empty.');
        }
    }

    public static function fromArray(array $credentials)
    {
        return new self($credentials);
    }

    public function apiKey()
    {
        return $this->credentials['api_key'];
    }

    public function endpoint()
    {
        return $this->credentials['endpoint'];
    }
}