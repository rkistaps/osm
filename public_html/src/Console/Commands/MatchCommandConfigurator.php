<?php

declare(strict_types=1);

namespace OSM\Console\Commands;

use OSM\Core\Models\Match;
use OSM\Core\Repositories\FriendlyInvitationRepository;
use OSM\Core\Repositories\MatchRepository;
use OSM\Core\Repositories\PlayerRepository;
use OSM\Modules\Series\Friendlies\Services\FriendlyInvitationService;
use OSM\Modules\Series\Friendlies\Structures\FriendlyInvitationParameters;
use Psr\Log\LoggerInterface;
use TheApp\Components\CommandRunner;

class MatchCommandConfigurator implements \TheApp\Interfaces\CommandConfiguratorInterface
{
    private const PREFIX = 'matches';
    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function configureCommands(CommandRunner $commandRunner)
    {
        $commandRunner->addCommand(self::PREFIX . '/check-friendly', function (MatchRepository $matchRepository) {
            $match = $matchRepository->findByRoundTypeAndTeam(1, Match::TYPE_FRIENDLY, 2);
            dd($match);
        });
        $commandRunner->addCommand(self::PREFIX . '/test', function (PlayerRepository $repository) {
            $players = $repository->getPlayersForTeamLineupId(4);

            dd($players);
        });

        $commandRunner->addCommand(self::PREFIX . '/invite-friendly', function (
            $homeTeamId,
            $awayTeamId,
            $round,
            FriendlyInvitationService $service
        ) {
            $invitation = new FriendlyInvitationParameters();
            $invitation->round = (int)$round;
            $invitation->homeTeamId = (int)$homeTeamId;
            $invitation->awayTeamId = (int)$awayTeamId;
            $service->processInvitation($invitation);
        });

        $commandRunner->addCommand(self::PREFIX . '/accept-friendly-invitation', function (
            int $id,
            FriendlyInvitationService $invitationService,
            FriendlyInvitationRepository $invitationRepository
        ) {
            $invitation = $invitationRepository->findById($id);
            if (!$invitation) {
                $this->logger->info('Invitation not found');
                return;
            }

            $invitationService->acceptInvitation($invitation);
        });
    }
}
