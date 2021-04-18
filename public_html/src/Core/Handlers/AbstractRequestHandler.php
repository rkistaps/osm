<?php

namespace OSM\Core\Handlers;

use League\Plates\Engine;
use OSM\Core\Factories\GenericFactory;
use OSM\Frontend\Core\Builders\ResponseBuilder;
use OSM\Frontend\Services\AlertService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionClass;

abstract class AbstractRequestHandler implements RequestHandlerInterface
{
    protected Engine $engine;
    protected GenericFactory $genericFactory;
    protected ResponseBuilder $responseBuilder;

    public function __construct(
        GenericFactory $genericFactory,
        ResponseBuilder $responseBuilder,
        Engine $engine
    ) {
        $this->responseBuilder = $responseBuilder;
        $this->engine = $engine;
        $this->genericFactory = $genericFactory;
    }

    abstract public function handle(ServerRequestInterface $request): ResponseInterface;

    protected function render(string $view, array $params = []): ResponseInterface
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

    public function getViewFolderPath(): string
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

    protected function reloadWithError(ServerRequestInterface $request, string $message): ResponseInterface
    {
        $alertService = $this->genericFactory->get(AlertService::class);
        $alertService->error($message);

        return $this->reload($request);
    }

    protected function reload(ServerRequestInterface $request): ResponseInterface
    {
        return $this->redirect($request->getUri()->getPath());
    }

    protected function isPost(ServerRequestInterface $request): bool
    {
        return $request->getMethod() === 'POST';
    }
}
