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

NEWS_RETRIEVAL_INTERVAL_MINUTES=1440
```

Run this command to run the schedules command.
```sh
php artisan schedule:run
```

Run the queue work command to start processing jobs on the queue.
```sh
php artisan queue:work
```

## Getting news articles
Use the `/api/news` endpoint to get news from the backend. This endpoint include parameters to filter your news results. These are:
1. Filter by source.
2. Filter by category.
3. Filter by dates.
4. Filter by author.
5. Filter by search term.
6. Specify news articles to return.

### Filter by source
Use the `sources` query parameter to filter news articles by source. This takes a list of sources separated by comma. For example, this url returns news articles from BBC News, CNN and Fox news.
```sh
/api/news?sources=bbc-news,cnn,fox-news
```

### Filter by category
Use the `categories` query parameter to filter news articles by category. This takes a list of categories separated by comma. For example, this url returns news articles from politics and football.
```sh
/api/news?categories=politics,football
```

### Filter by author
Use the `authors` query parameter to filter news articles by author. This takes a list of author names separated by comma. For example, this url returns news articles from Pep and Maudlina Brown.
```sh
/api/news?authors=Pep,Maudlina Brown
```

### Filter by dates
Use the `from` and `to` query parameters to filter news articles by publication date. This takes a date in the format `Y-m-d H:i:s`. For example, lets get the news between 20th December, 2024 and 22nd December, 2024.
```sh
/api/news?from=2024-12-20 16:20:00&to=2024-12-22 16:20:00
```

### Filter by search term
Use the `q` query parameter to search article using a term. This searches the articles title and contents.
```sh
/api/news?q=laravel
```

### Specify the number of news articles to return
You can specify the number of news articles to return by using the `per_page` query parameter. The results will be paginates if there are more articles to be fetched.
```sh
/api/news?per_page=20
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