<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Site\Handlers;

use OSM\Core\Handlers\AbstractRequestHandler;
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
            return $this->reload($request); // todo add message
        }

        return $this->render('register', [
            'model' => $viewModel,
        ]);
    }

    public function processRegistration(
        RegistrationViewModel $viewModel
    ): bool {
        $service = $this->genericFactory->get(RegistrationService::class);

        return $service->processRegistration($viewModel);
    }
}
