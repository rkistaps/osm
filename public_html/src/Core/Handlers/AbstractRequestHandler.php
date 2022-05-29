<?php

namespace OSM\Core\Handlers;

use League\Plates\Engine;
use OSM\Core\Factories\GenericFactory;
use OSM\Core\Models\Team;
use OSM\Core\Repositories\TeamRepository;
use OSM\Core\Translations\Structures\Domains;
use OSM\Frontend\Core\Builders\ResponseBuilder;
use OSM\Frontend\Exceptions\Http\HttpNotFoundException;
use OSM\Frontend\Services\AlertService;
use OSM\Frontend\Structures\Alert;
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

        $this->init();
    }

    abstract public function handle(ServerRequestInterface $request): ResponseInterface;

    protected function init()
    {
    }

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

    protected function reloadWithSuccess(ServerRequestInterface $request, string $message): ResponseInterface
    {
        $alertService = $this->genericFactory->get(AlertService::class);
        $alertService->success($message);

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

    public function addAlert(string $type, string $message, bool $isFlash = true)
    {
        $this->genericFactory->get(AlertService::class)->addAlert(
            $type,
            $message,
            $isFlash
        );
    }

    public function addErrorAlert(string $message, bool $isFlash = true)
    {
        $this->addAlert(Alert::TYPE_ERROR, $message, $isFlash);
    }

    public function getActiveTeam(ServerRequestInterface $request): ?Team
    {
        return $this->getTeam((int)$request->getAttribute('active-team-id'));
    }

    /**
     * @throws HttpNotFoundException
     */
    protected function getTeam(int $teamId = null): Team
    {
        $team = $this->genericFactory->get(TeamRepository::class)->findById($teamId);

        if (!$team) {
            throw new HttpNotFoundException(_d(Domains::DOMAIN_FRONTEND, 'Team not found'));
        }

        return $team;
    }

    public function getPostParam(string $paramName, ServerRequestInterface $request, $default = null)
    {
        if (!$this->isPost($request)) {
            return null;
        }

        return $request->getParsedBody()[$paramName] ?? $default;
    }

    public function hasPostParam(string $paramName, ServerRequestInterface $request): bool
    {
        if (!$this->isPost($request)) {
            return false;
        }

        return isset($request->getParsedBody()[$paramName]);
    }
}
