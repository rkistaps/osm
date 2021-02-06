<?php

declare(strict_types=1);

namespace OSM\Console\Handlers\Matches\Friendlies;

use OSM\Modules\Series\Friendlies\Exceptions\FriendlyAlreadyBookedException;
use OSM\Modules\Series\Friendlies\Services\FriendlyInvitationService;
use OSM\Modules\Series\Friendlies\Structures\FriendlyInvitationParameters;
use Psr\Log\LoggerInterface;

class FriendlyInviteHandler implements \TheApp\Interfaces\CommandHandlerInterface
{
    private FriendlyInvitationService $invitationService;
    private LoggerInterface $logger;

    public function __construct(
        FriendlyInvitationService $invitationService,
        LoggerInterface $logger
    ) {
        $this->invitationService = $invitationService;
        $this->logger = $logger;
    }

    public function handle(array $params = [])
    {
        $invitation = FriendlyInvitationParameters::fromArray($params);
        try {
            $this->invitationService->processInvitation($invitation);
        } catch (FriendlyAlreadyBookedException $e) {
            $this->logger->info($e->getMessage());
        }
    }
}
