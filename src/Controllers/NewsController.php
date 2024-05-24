<?php

namespace Mark\Controllers;

use Mark\Services\NewsService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class NewsController
 * 
 * Controller class for news-related operations.
 * 
 * @package Mark\Controllers
 */
class NewsController
{
    /**
     * @var NewsService The news service instance
     */
    private NewsService $newsService;

    /**
     * NewsController constructor.
     * 
     * @param NewsService $newsService The news service instance
     */
    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * List all news.
     *
     * @param Request $request The HTTP request
     * @param Response $response The HTTP response
     * @return Response The HTTP response
     */
    public function listNews(Request $request, Response $response): Response
    {
        $newsList = $this->newsService->listNews();
        $body = '';

        foreach ($newsList as $news) {
            $body .= "############ NEWS " . $news->getTitle() . " ############\n";
            $body .= $news->getBody() . "\n";
        }

        $response->getBody()->write($body);
        return $response;

    }
}
