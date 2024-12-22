<?php

namespace Tests\Feature;

use App\Actions\NewsRetrievalHandler;
use App\Source\SourceManager;
use App\Jobs\GetNews;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class NewsRetrievalHandlerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_news_from_several_sources(): void
    {
        Queue::fake();

        Config::set('news-sources.sources.news_api.api_key', '123abc');
        Config::set('news-sources.sources.news_api.endpoint', $this->faker->url());

        Config::set('news-sources.sources.new_york_times.api_key', '123abc');
        Config::set('news-sources.sources.new_york_times.endpoint', $this->faker->url());

        Config::set('news-sources.sources.guardian.api_key', '123abc');
        Config::set('news-sources.sources.guardian.endpoint', $this->faker->url());

        $newsRetrievalHander = new NewsRetrievalHandler(new SourceManager());

        $newsRetrievalHander->execute();

        Queue::assertPushed(GetNews::class, 3);
    }
}
