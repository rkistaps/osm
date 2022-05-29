<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Lineup\Handlers;

use OSM\Core\Handlers\AbstractRequestHandler;
use OSM\Core\Translations\Structures\Domains;
use OSM\Frontend\Modules\Lineup\Services\LineupSaveTacticsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LineupSaveTacticsHandler extends AbstractRequestHandler implements RequestHandlerInterface
{
    protected LineupSaveTacticsService $saveTacticsService;

    protected function init()
    {
        $this->saveTacticsService = $this->genericFactory->get(LineupSaveTacticsService::class);
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $team = $this->getActiveTeam($request);

        if ($this->saveTacticsService->processSave($this->getPostParam('tactic', $request), $team)) {
            $this->addSuccessAlert(_d(Domains::DOMAIN_FRONTEND, 'Tactics saved'));
        }

        return $this->redirectBack($request);
    }
}