# New Aggregator

Take-home challenge for the Backend web developer position.

## Setup

The application fetches articles from NewsAPI, The Guardian and The New York Times.
Firstly, you have to setup the environment variables for these news sources.
Get the API keys from the news sources and set them in .env file.

Set the value for the NEWS_RETRIEVAL_INTERVAL_MINUTES environment variable. This is the number of intervals used to fetch the articles. 

```sh
NEWSAPI_APIKEY=
NEWSAPI_ENDPOINT=https://newsapi.org/v2/everything

GUARDIANAPI_APIKEY=
GUARDIANAPI_ENDPOINT=https://content.guardianapis.com/search

NEWYORKTIMES_APIKEY=
NEWYORKTIMES_ENDPOINT=https://api.nytimes.com/svc/search/v2/articlesearch.json

NEWS_RETRIEVAL_INTERVAL_MINUTES=
```

Run the queue work command to start processing jobs on the queue.
```sh
php artisan queue:work
```

## Add more news sources
This application has been built to make it easier to fetch news from more sources. To do this:

1. Add the API Key and the Endpoint of the source to the env file.
2. Add a key to the list of sources in the config/news-sources file
3. Add a Source class for your news source.
This class should extend the App\Actions\Source\Source class. Your class should implement the url() method.

```sh
class BbcNews extends Source
{
    public function url()
    {
        //
    }
}
```

4. Add a Transformer class to transform the data when articles are fetched from the source. Your transformer class should extend the App\Transformers\Transformer class.
Your transform class should implement the following methods:
- getArticle(array $data): array - This method should transform an article to be saved in the database.
- getAuthor(array $data): string - This method should transform an author to be saved in the database.
- getCategory(array $data): array - This method should transform a category for the article to be saved in the database.
- getSource(array $data): array - This method should transform a source of the article to be saved in the database.
- isValid(array $data): bool - This method determines whether an articles should be transformed so it can be saved in the database.

```sh
class BbcNews extends Transformer
{
    public function getArticle(array $data): array
    {
        //...
    }

    public function getAuthor(array $data): string
    {
        //...
    }

    public function getCategory(array $data): array
    {
        //...
    }

    public function getSource(array $data): array
    {
        //...
    }

    public function isValid(array $data): bool
    {
        //...
    }
}
```
