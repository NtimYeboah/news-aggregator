<?php

namespace App\Transformers;

use App\Transformers\Transformer;

class NewYorkTimes extends Transformer
{
    public ?string $status;
    public array $news;

    public function __construct(array $response)
    {
        $this->status = $response['status'];
        $this->news = $response['response']['docs'];
    }

    public function getArticle(array $data)
    {
        return [
            'title' => $data['headline']['main'],
            'description' => $data['lead_paragraph'],
            'content' => $data['content'] ?? null,
            'url' => $data['web_url'],
            'image_url' => $data['multimedia'][0]['url'],
            'published_at' => $data['pub_date'],
        ];
    }

    public function getAuthor(array $data)
    {
        $person = $data['byline']['person'];

        if (count($person) > 0) {
            return $person[0]['firstname'] . ' ' . $person[0]['lastname'];
        }

        return null;
    }

    public function getCategory(array $data)
    {
        return [
            'name' => $data['news_desk'] ?? $data['section_name'] ?? $data['subsection_name'],
        ];
    }

    public function getSource(array $data)
    {
        return [
            'name' => 'New York Times',
        ];
    }

    public function isValid(array $data)
    {
        return true;
    }
}
