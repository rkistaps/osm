<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Site\Handlers;

use OSM\Core\Handlers\AbstractRequestHandler;
use OSM\Core\Models\Match;
use OSM\Core\Repositories\ChampionshipRepository;
use OSM\Core\Repositories\CountryRepository;
use OSM\Frontend\Modules\Site\Services\RegistrationService;
use OSM\Frontend\Modules\Site\ViewModels\RegistrationViewModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RegisterRequestHandler extends AbstractRequestHandler
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $viewModel = RegistrationViewModel::fromRequest($request);
        if ($this->isPost($request) && $this->processRegistration($viewModel)) {
            return $this->reloadWithSuccess($request, _d('frontend', 'Registration successful. You may log in now.'));
        }

        $countries = $this->genericFactory->get(CountryRepository::class)->findAll()->sortBy('name');
        $championships = $this->genericFactory
            ->get(ChampionshipRepository::class)
            ->findByType(Match::TYPE_CHAMPIONSHIP_LEAGUE)
            ->sortBy('name');

        return $this->render('register', [
            'model' => $viewModel,
            'countries' => $countries,
            'championships' => $championships,
        ]);
    }

    public function processRegistration(
        RegistrationViewModel $viewModel
    ): bool {
        $service = $this->genericFactory->get(RegistrationService::class);

        return $service->processRegistration($viewModel);
    }
}
