<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Friendlies\Services;

use OSM\Core\Models\FriendlyInvitation;
use OSM\Core\Models\Match;
use OSM\Core\Repositories\FriendlyInvitationRepository;
use OSM\Core\Repositories\MatchRepository;
use OSM\Modules\Series\Friendlies\Exceptions\FriendlyAlreadyBookedException;
use OSM\Modules\Series\Friendlies\Structures\FriendlyInvitationParameters;

class FriendlyInvitationService
{
    private FriendlyInvitationRepository $invitationRepository;
    private MatchRepository $matchRepository;

    public function __construct(
        FriendlyInvitationRepository $invitationRepository,
        MatchRepository $matchRepository
    ) {
        $this->matchRepository = $matchRepository;
        $this->invitationRepository = $invitationRepository;
    }

    /**
     * @param FriendlyInvitationParameters $invitation
     * @throws FriendlyAlreadyBookedException
     */
    public function processInvitation(FriendlyInvitationParameters $invitation)
    {
        if ($this->hasMatchInRound($invitation->awayTeamId, $invitation->round)) {
            throw new FriendlyAlreadyBookedException();
        }

        if ($this->hasMatchInRound($invitation->homeTeamId, $invitation->round)) {
            throw new FriendlyAlreadyBookedException(t("Your team already has a friendly in this round"));
        }

        $invitationModel = new FriendlyInvitation();
        $invitationModel->homeTeamId = $invitation->homeTeamId;
        $invitationModel->awayTeamId = $invitation->awayTeamId;
        $invitationModel->round = $invitation->round;

        $this->invitationRepository->saveModel($invitationModel);
        // todo send notification
    }

    /**
     * @param FriendlyInvitation $invitation
     * @throws FriendlyAlreadyBookedException
     */
    public function acceptInvitation(FriendlyInvitation $invitation)
    {
        if ($this->hasMatchInRound($invitation->homeTeamId, $invitation->round)) {
            throw new FriendlyAlreadyBookedException();
        }

        if ($this->hasMatchInRound($invitation->awayTeamId, $invitation->round)) {
            throw new FriendlyAlreadyBookedException(t("Your team already has a friendly in this round"));
        }

        $this->buildMatchFromInvitation($invitation);

        // todo send notification

        $this->invitationRepository->deleteModel($invitation);
    }

    public function buildMatchFromInvitation(FriendlyInvitation $invitation): Match
    {
        $match = new Match();
        $match->homeTeamId = $invitation->homeTeamId;
        $match->awayTeamId = $invitation->awayTeamId;
        $match->seriesType = Match::TYPE_FRIENDLY;
        $match->seriesRound = $invitation->round;

        $this->matchRepository->saveModel($match);

        return $match;
    }

    public function hasMatchInRound(int $teamId, int $round): bool
    {
        return !!$this->matchRepository->findByRoundTypeAndTeam($round, Match::TYPE_FRIENDLY, $teamId);
    }
}
