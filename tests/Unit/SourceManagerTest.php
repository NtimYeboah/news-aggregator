<?php

namespace Tests\Unit;

use App\Source\SourceManager;
use App\Source\Sources\Guardian;
use App\Source\Sources\NewsApi;
use App\Source\Sources\NewYorkTimes;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class SourceManagerTest extends TestCase
{
    public function test_can_make_sources_from_configuration(): void
    {
        Config::set('news-sources.sources.news_api.api_key', '123abc');
        Config::set('news-sources.sources.news_api.endpoint', 'https://newsapi.org');

        Config::set('news-sources.sources.new_york_times.api_key', '123abc');
        Config::set('news-sources.sources.new_york_times.endpoint', 'https://newyorktimes-api.org');

        Config::set('news-sources.sources.guardian.api_key', '123abc');
        Config::set('news-sources.sources.guardian.endpoint', 'https://api.guardian.org');

        $sources = (new SourceManager())->get();
    
        $this->assertCount(3, $sources);

        $this->assertInstanceOf(NewsApi::class, $sources->get(0));
        $this->assertInstanceOf(NewYorkTimes::class, $sources->get(1));
        $this->assertInstanceOf(Guardian::class, $sources->get(2));
    }
}