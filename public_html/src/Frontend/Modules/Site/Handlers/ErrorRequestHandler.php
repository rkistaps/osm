<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Site\Handlers;

use OSM\Frontend\Modules\Site\Factories\ErrorResponseFactory;
use Psr\Http\Message\ResponseInterface;
use TheApp\Interfaces\ErrorHandlerInterface;
use Throwable;

class ErrorRequestHandler implements ErrorHandlerInterface
{
    private ErrorResponseFactory $responseFactory;

    public function __construct(ErrorResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function handle(Throwable $throwable): ResponseInterface
    {
        return $this->responseFactory->buildFromThrowable($throwable);
    }
}