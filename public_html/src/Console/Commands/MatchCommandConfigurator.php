<?php

declare(strict_types=1);

namespace OSM\Console\Commands;

use OSM\Console\Handlers\Matches\Friendlies\FriendlyAcceptInviteHandler;
use OSM\Console\Handlers\Matches\Friendlies\FriendlyInviteHandler;
use OSM\Console\Handlers\Matches\Friendlies\FriendlyRunRoundHandler;
use OSM\Console\Handlers\Matches\MatchRunnerHandler;
use OSM\Core\Models\Match;
use OSM\Core\Repositories\MatchRepository;
use OSM\Core\Repositories\PlayerRepository;
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
        });

        # Run a match
        $commandRunner->addCommand(self::PREFIX . '/run', MatchRunnerHandler::class);

        # Friendlies
        $commandRunner->addCommand(self::PREFIX . '/run-friendly-round', FriendlyRunRoundHandler::class);
        $commandRunner->addCommand(self::PREFIX . '/invite-friendly', FriendlyInviteHandler::class);
        $commandRunner->addCommand(self::PREFIX . '/accept-friendly-invitation', FriendlyAcceptInviteHandler::class);
    }
}
