<?php

namespace App\Transformers;

use App\Actions\SaveNewsHandler;

abstract class Transformer
{
    public array $news;

    public abstract function getArticle(array $data);

    public abstract function getAuthor(array $data);

    public abstract function getCategory(array $data);

    public abstract function getSource(array $data);

    public abstract function isValid(array $data);

    public function process()
    {
        foreach ($this->news as $news) {
            if (! $this->isValid($news)) {
                continue;
            }

            $transformed = $this->transform($news);
            
            (new SaveNewsHandler($transformed))->execute();
        }
    }

    public function transform(array $data)
    {
        return [
            'source' => $this->getSource($data),
            'category' => $this->getCategory($data),
            'author' => $this->getAuthor($data),
            'article' => $this->getArticle($data),
        ];
    }
}