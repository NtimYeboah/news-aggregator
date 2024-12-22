<?php

namespace App\Transformers;

use App\Transformers\Transformer;

class Guardian extends Transformer
{
    public ?string $status;
    public ?string $totalResults;
    public ?string $pages;
    public ?string $currentPage;
    public array $news;

    public function __construct(array $response)
    {
        $this->status = $response['response']['status'];
        $this->totalResults = $response['response']['total'];
        $this->pages = $response['response']['pages'];
        $this->currentPage = $response['response']['currentPage'];
        $this->news = $response['response']['results'];
    }

    public function getArticle(array $data)
    {
        return [
            'title' => $data['webTitle'],
            'description' => $data['description'] ?? null,
            'content' => $data['content'] ?? null,
            'url' => $data['webUrl'],
            'image_url' => $data['urlToImage'] ?? null,
            'api_url' => $data['apiUrl'] ?? null,
            'published_at' => $data['webPublicationDate'],
        ];
    }

    public function getAuthor(array $data)
    {
        return 'Guardian';
    }

    public function getCategory(array $data)
    {
        return [
            'name' => $data['sectionName'] ?? null,
        ];
    }

    public function getSource(array $data)
    {
        return [
            'name' => 'Guardian',
        ];
    }

    public function isValid(array $data)
    {
        return true;
    }
}
