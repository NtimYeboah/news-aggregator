<?php

namespace Tests\Unit;

use App\Actions\Source\SourceManager;
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
    }
}