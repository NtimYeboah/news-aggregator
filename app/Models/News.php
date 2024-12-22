<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class News extends Model
{
    use HasFactory;
    
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public static function saveOne(Source $source, Author $author, Category $category, $details)
    {
        $news = new self;

        $news->source_id = $source->getKey();
        $news->category_id = $category->getKey();
        $news->author_id = $author->getKey();
        $news->title = Arr::get($details, 'title');
        $news->description = Arr::get($details, 'description');
        $news->content = Arr::get($details, 'content');
        $news->url = Arr::get($details, 'url');
        $news->image_url = Arr::get($details, 'image_url');
        $news->published_at = Arr::get($details, 'publishedAt');

        $news->save();
    }
}
