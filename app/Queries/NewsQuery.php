<?php

namespace App\Queries;

use App\Models\Author;
use App\Models\Category;
use App\Models\News;
use App\Models\Source;
use Illuminate\Support\Arr;

class NewsQuery
{
    public ?string $term;
    public ?string $dateFrom;
    public ?string $dateTo;
    public ?string $sources;
    public ?string $authors;
    public ?string $categories;
    
    public const PER_PAGE = 50;

    public function __construct(array $queryParameters)
    {
        $this->term = Arr::get($queryParameters, 'q');
        $this->dateFrom = Arr::get($queryParameters, 'from');
        $this->dateTo = Arr::get($queryParameters, 'to');
        $this->sources = Arr::get($queryParameters, 'sources');
        $this->authors = Arr::get($queryParameters, 'authors');
        $this->categories = Arr::get($queryParameters, 'categories');
    }

    public function run()
    {
        return News::query()
            ->when($this->sources, function ($query) {
                $query->whereIn('source_id', Source::query()->whereIn('slug', explode(',',$this->sources))->select('id'));
            })
            ->when($this->authors, function ($query) {
                $query->whereIn('author_id', Author::query()->whereIn('name', explode(',', $this->authors))->select('id'));
            })
            ->when($this->categories, function ($query) {
                $query->whereIn('category_id', Category::query()->whereIn('slug', explode(',', $this->categories))->select('id'));
            })
            ->when($this->term, function ($query) {
                $query->where('title', 'LIKE', '%' . $this->term . '%')
                    ->orWhere('content', 'LIKE', '%' . $this->term . '%');
            })
            ->when($this->dateFrom, function ($query) {
                $query->where('published_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->where('published_at', '<=', $this->dateTo);
            })
            ->select('news.*')
            ->paginate(self::PER_PAGE);
    }
}

