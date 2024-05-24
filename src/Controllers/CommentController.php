<?php

namespace Mark\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Mark\Services\CommentService;

class CommentController
{

    public function __construct(private CommentService $service)
    {
        
    }

    public function listComments(Request $request, Response $response)
    {
        $commentList = $this->service->listComments();
        $body = '';

        foreach ($commentList as $comment) {
            $body .= "Comment " . $comment->getId() . " : " . $comment->getBody() . "\n";
        }

        $response->getBody()->write($body);
        return $response;
    }
}
