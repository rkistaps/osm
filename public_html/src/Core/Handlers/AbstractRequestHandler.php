<?php

namespace OSM\Core\Handlers;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionClass;
use TheApp\Components\Builders\ResponseBuilder;

abstract class AbstractRequestHandler implements RequestHandlerInterface
{
    protected ResponseBuilder $responseBuilder;
    protected Engine $engine;

    public function __construct(
        ResponseBuilder $responseBuilder,
        Engine $engine
    ) {
        $this->responseBuilder = $responseBuilder;
        $this->engine = $engine;
    }

    abstract public function handle(ServerRequestInterface $request): ResponseInterface;

    protected function render(string $view, array $params = [])
    {
        return $this->responseBuilder->withContent(
            $this->engine->render($this->getViewPath($view), $params)
        )->build();
    }

    protected function getViewPath(string $path): string
    {
        // use view relative to Templates path
        if ($path[0] === '/') {
            return $path;
        }

        $this->engine->addFolder(get_called_class(), $this->getViewFolderPath());

        return get_called_class() . '::' . $path;
    }

    public function getViewFolderPath()
    {
        $class = new ReflectionClass($this);

        return dirname($class->getFileName(), 2) . DIRECTORY_SEPARATOR . 'Views';
    }

    protected function redirect(string $location, int $code = 302): ResponseInterface
    {
        return $this->responseBuilder->withRedirect($location, $code)->build();
    }

    protected function redirectBack(ServerRequestInterface $request, string $default = '/'): ResponseInterface
    {
        $referer = $request->getHeader('Referer')[0] ?? $default;
        return $this->redirect($referer, 302);
    }

    protected function reload(ServerRequestInterface $request): ResponseInterface
    {
        return $this->redirect($request->getUri()->getPath());
    }
}
