<?php

declare(strict_types=1);

namespace OSM\Console\Handlers\Matches\Friendlies;

use OSM\Core\Repositories\FriendlyInvitationRepository;
use OSM\Modules\Series\Friendlies\Exceptions\FriendlyAlreadyBookedException;
use OSM\Modules\Series\Friendlies\Services\FriendlyInvitationService;
use Psr\Log\LoggerInterface;
use TheApp\Interfaces\CommandHandlerInterface;

class FriendlyAcceptInviteHandler implements CommandHandlerInterface
{
    private LoggerInterface $logger;
    private FriendlyInvitationRepository $invitationRepository;
    private FriendlyInvitationService $invitationService;

    public function __construct(
        LoggerInterface $logger,
        FriendlyInvitationRepository $invitationRepository,
        FriendlyInvitationService $invitationService
    ) {
        $this->logger = $logger;
        $this->invitationRepository = $invitationRepository;
        $this->invitationService = $invitationService;
    }

    public function handle(array $params = [])
    {
        $id = (int)($params['id'] ?? null);
        if (!$id) {
            $this->logger->error('Incorrect invite id');
            return;
        }

        $invitation = $this->invitationRepository->findById($id);
        if (!$invitation) {
            $this->logger->info('Invitation not found');
            return;
        }

        try {
            $this->invitationService->acceptInvitation($invitation);
        } catch (FriendlyAlreadyBookedException $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
