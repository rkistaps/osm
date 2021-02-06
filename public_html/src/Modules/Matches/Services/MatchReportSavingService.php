<?php

declare(strict_types=1);

namespace OSM\Modules\Matches\Services;

use OSM\Core\Models\Match;
use OSM\Core\Models\MatchReport;
use OSM\Core\Repositories\MatchReportRepository;
use OSM\Core\Repositories\MatchReportTextRepository;
use OSM\Modules\MatchEngine\Structures\MatchEvent;
use OSM\Modules\MatchEngine\Structures\MatchResult;

class MatchReportSavingService
{
    private const CACHE_KEY = 'match-report-texts';

    private MatchReportRepository $matchReportRepository;
    private MatchReportTextRepository $matchReportTextRepository;

    public function __construct(
        MatchReportRepository $matchReportRepository,
        MatchReportTextRepository $matchReportTextRepository
    ) {
        $this->matchReportRepository = $matchReportRepository;
        $this->matchReportTextRepository = $matchReportTextRepository;
    }

    public function saveMatchReport(Match $match, MatchResult $result)
    {
        foreach ($result->events as $event) {
            $reportType = $this->getReportType($event);
            $objectData = [
                    'match_id' => $match->id,
                    'minute' => $event->getMinute(),
                    'event_type' => $event->getType(),
                    'report_type' => $reportType,
                    'match_report_text_id' => $this->getRandomTextId($reportType),
                ] + $this->getEventPlayers($event);

            $this->matchReportRepository->createModel($objectData, true);
        }
    }

    protected function getEventPlayers(MatchEvent $event): array
    {
        $data = [];

        if ($event->isType(MatchEvent::TYPE_GOAL) || $event->isType(MatchEvent::TYPE_SAVE)) {
            $data['player_a_id'] = $event->getStrikerId();
            $data['player_b_id'] = $event->getData()['goalkeeper'] ?? null;

            if ($event->hasAttackHelper()) {
                $data['helper_a_id'] = $event->getData()['attackHelperId'] ?? null;
            }
            if ($event->hasDefenseHelper()) {
                $data['helper_b_id'] = $event->getData()['defenseHelperId'] ?? null;
            }
        }

        return $data;
    }

    protected function getReportType(MatchEvent $event): string
    {
        if ($event->isType(MatchEvent::TYPE_GOAL)) { // goal
            if ($event->hasAttackHelper() && $event->hasDefenseHelper()) { // 2v2
                return MatchReport::REPORT_TYPE_2V2_GOAL;
            } elseif ($event->hasAttackHelper()) { // 2v1
                return MatchReport::REPORT_TYPE_2V1_GOAL;
            } elseif ($event->hasDefenseHelper()) { // 1v2
                return MatchReport::REPORT_TYPE_1V2_GOAL;
            }
            // 1v1
            return MatchReport::REPORT_TYPE_1V1_GOAL;
        } elseif ($event->isType(MatchEvent::TYPE_SAVE)) { // save
            if ($event->hasAttackHelper() && $event->hasDefenseHelper()) { // 2v2
                return MatchReport::REPORT_TYPE_2V2_SAVE;
            } elseif ($event->hasAttackHelper()) { // 2v1
                return MatchReport::REPORT_TYPE_2V1_SAVE;
            } elseif ($event->hasDefenseHelper()) { // 1v2
                return MatchReport::REPORT_TYPE_1V2_SAVE;
            }
            // 1v1
            return MatchReport::REPORT_TYPE_1V1_SAVE;
        }

        return $event->getType();
    }

    protected function getRandomTextId(string $reportType): int
    {
        $texts = $this->matchReportTextRepository->getTextsByType($reportType);

        return collect(array_keys($texts))->random();
    }
}
