<?php

namespace App\Transformers;

use App\Transformers\Transformer;

class NewsApi extends Transformer
{
    public ?string $status;
    public ?string $totalResults;
    public array $news;

    public function __construct(array $response)
    {
        $this->status = $response['status'];
        $this->totalResults = $response['totalResults'];
        $this->news = $response['articles'];
    }

    public function getArticle(array $data)
    {
        return [
            'title' => $data['title'],
            'description' => $data['description'],
            'content' => $data['content'],
            'url' => $data['url'],
            'image_url' => $data['urlToImage'],
            'published_at' => $data['publishedAt'],
        ];
    }

    public function getAuthor(array $data)
    {
        return $data['author'] ?? null;
    }

    public function getCategory(array $data)
    {
        return [];
    }

    public function getSource(array $data)
    {
        return $data['source'];
    }

    public function isValid(array $data)
    {
        return $data['source']['name'] !== '[Removed]';
    }
}
