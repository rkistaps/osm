<?php

declare(strict_types=1);

namespace OSM\Console\Handlers\Bots;

use OSM\Core\Repositories\CountryRepository;
use OSM\Modules\Bots\Creation\Services\BotCreationService;
use TheApp\Interfaces\CommandHandlerInterface;

class BotCreationCommandHandler implements CommandHandlerInterface
{
    private CountryRepository $countryRepository;
    private BotCreationService $botCreationService;

    public function __construct(
        CountryRepository $countryRepository,
        BotCreationService $botCreationService
    ) {
        $this->countryRepository = $countryRepository;
        $this->botCreationService = $botCreationService;
    }

    public function handle(array $params = [])
    {
        $countryId = $params['countryId'] ?? null;

        $country = ($countryId) ? $this->countryRepository->findById($countryId) : null;

        $result = $this->botCreationService->addBot($country);

        dd($result);
    }
}
