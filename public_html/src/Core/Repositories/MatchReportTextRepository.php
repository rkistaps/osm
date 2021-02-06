<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Models\MatchReport;

class MatchReportTextRepository
{
    public function getTexts(): array
    {
        return [
            MatchReport::REPORT_TYPE_1V1_GOAL => [
                t('Great goal by [striker]! [goalkeeper] could not do anything about it.'),
                t('Wonderful goal by [striker] from just outside of the penalty area! [goalkeeper] could not do anything about it.'),
                t('Despite of best effort by [goalkeeper], [striker] scores a great goal.'),
                t('[striker] does some fine movement down the right side and puts the ball in back of the [goalkeeper] net.'),
                t('[striker] does some fine movement down the left side and puts the ball in back of the [goalkeeper] net.'),
                t('[striker] makes an excellent move down the center and puts the ball in back of the [goalkeeper] net.'),
                t('[goalkeeper] just managed to tip the shot by [striker], but it was not enough to save it! Great goal by [striker].'),
                t('Great header by [striker] results in fine goal.'),
                t('xxx'),
            ],
            MatchReport::REPORT_TYPE_1V1_SAVE => [
                t('Great shoot by [striker], but even better save by [goalkeeper]!'),
                t('Despite of a good position by [striker], [goalkeeper] was able to stop his shoot!'),
                t('[goalkeeper] manages to save his team after fantastic shoot by [striker].'),
                t('[goalkeeper] tip the ball over the crossbar after [striker] shoot in top of the left corner.'),
                t('[goalkeeper] tip the ball over the crossbar after [striker] shoot in top of the right corner.'),
                t('[goalkeeper] somehow was able to block [striker] shoot! What a fantastic save!'),
            ],
            MatchReport::REPORT_TYPE_1V2_GOAL => [
                t('After getting by [helper_defense], [player] also managed to beat [goalkeeper] and made fine goal.'),
                t('[helper_defense] did his best to stop [player], who still managed to over run him and put the ball in the back of [goalkeeper] net! Fantastic goal!'),
                t('Excellent move by [player], leaves [helper_defense] behind. [player] beats [goalkeeper] to score fine goal.'),
                t('[player] uses his skill to beat both [helper_defense] and [goalkeeper]! Spectacular goal! '),
                t('[helper_defense] was not able to block [player] shoot in top of the right corner! [goalkeeper] has to take ball of of his teams net.'),
                t('[helper_defense] was not able to block [player] shoot in top of the left corner! [goalkeeper] has to take ball of of his teams net.'),
                t('[player] came in off the right and dribbled past [helper_defense], to beat [goalkeeper] in excellent style!'),
                t('[player] came in off the left and dribbled past [helper_defense], to beat [goalkeeper] in excellent style!'),
            ],
            MatchReport::REPORT_TYPE_1V2_SAVE => [
                t('Even though [player] somehow managed to get by [helper_defense], he was far from best position to score and his shoot was easily saved by [goalkeeper].'),
                t('[helper_defense] puts his leg in front of [player] shot and [goalkeeper] makes easy save.'),
                t('[helper_defense] with a tight defense helped [goalkeeper] to save [player] shot.'),
                t('[player] couldn\'t get past [helper_defense], so he tried his luck from outside of the penalty are. His shot was blocked by [goalkeeper].'),
                t('[player] couldn\'t get past [helper_defense], so he tried his luck from outside of the penalty are. His shot was easly saved by [goalkeeper].'),
            ],
            MatchReport::REPORT_TYPE_2V1_GOAL => [
                t('[player] and [assist_attack] managed to get by all defenders and after great passing [player] put ball in empty net. '),
            ],
            MatchReport::REPORT_TYPE_2V1_SAVE => [
                t('Even though [player] and [assist_attack] was left alone against [goalkeeper] they did not manage to get ball into the net.'),
            ],
            MatchReport::REPORT_TYPE_2V2_GOAL => [
                t('Great pass by [assist_attack] to [striker] who dribbles by [defender] and puts ball in [goalkeeper] goal.'),
                t('Great long cross from right side by [assist_attack] and [striker] gets by [defender] to but the ball in [goalkeeper] net.'),
                t('Great long cross from left side by [assist_attack] and [striker] gets by [defender] to but the ball in [goalkeeper] net.'),
                t('[assist_attack] with a great pass beats [defender]. [striker] was able to take an advantage and beat [goalkeeper] to score a brilliant goal.'),
                t('Fine play by [assist_attack], who runs past [defender] and gives an excellent pass to [striker], who scores great header! '),
                t('Excellent play by [assist_attack], who runs past [defender] and gives a fine pass to [striker], who beat [goalkeeper] with a crushing strike!'),
            ],
            MatchReport::REPORT_TYPE_2V2_SAVE => [
                t('Although a great pass by [assist_attack], [striker] could not get by [assist_defense] and his shot was easily saved by [goalkeeper]. '),
                t('[assist_attack] crosses long ball to the [striker], but he was not able to beat [assist_defense], and [goalkeeper] made good save.'),
                t('[goalkeeper] made a spectacular save after good combination between [assist_attack] and [striker]. [assist_defense] was able to help by blocking nearest side of the net.'),
            ],
            MatchReport::REPORT_TYPE_ATTACK_STOP => [
                t('[attacking_team] attack was stopped by [defending_team].'),
                t('Potentially good attack by [attacking_team] broke down at the midfield.'),
                t('Brilliant defense by [defending_team] stopped another [attacking_team] attack.'),
                t('[defending_team] are all over [attacking_team] here. There is no way through!'),
            ],
            MatchReport::REPORT_TYPE_INJURY => [
                t('Looks like [player] is in a lot of pain and is coming off the field'),
            ],
            MatchReport::REPORT_TYPE_INJURY_WITH_A_SUB => [
                t('[player] gets injured. [substitute] comes into the game as a replacement.'),
                t('[player] spent some time on grass, before was replaced by [substitute].'),
                t('Rough tackle leads to [player] injury. [substitute] comes into the game as a replacement.'),
                t('Looks like [player] is having some pain in ankle. Coach decided to substitute him with [substitute].'),
                t('[player] clearly wont be able to continue game. [substitute] comes into the game as a replacement.'),
                t('We can see some pain in [player] face as he is replaced by [substitute].'),
            ],
            MatchReport::REPORT_TYPE_YELLOW_CARD => [
                t('[player] receives yellow card for nasty play.'),
                t('Referee shows yellow card after hand play by [player].'),
                t('Hard tackle by [player] leaves no choice referee but to show yellow card.'),
                t('[player] get booked for wasting the time.'),
                t('[player] will go into referees pocket after this challenge! Well deserved yellow card.'),
            ],
            MatchReport::REPORT_TYPE_PENALTY_GOAL => [
                t('[player] took a penalty and made a fine goal.'),
                t('[player] sent [goalkeeper] the wrong way and chipped the ball into the empty net.'),
            ],
            MatchReport::REPORT_TYPE_PENALTY_SAVE => [
                t('[player] took a penalty, but [goalkeeper] made a fine save.'),
            ],
            MatchReport::REPORT_RED_CARD => [
                t('After wild challenge [player] has been sent off.'),
                t('[player] has been sent off due to terrible tackle.'),
                t('Referee shows red card to [player] as result to horrible tackle.'),
                t('[player] punches his opponent. Referee goes into his pocket and it is s a red card!'),
            ],
            MatchReport::REPORT_TYPE_SECOND_YELLOW_CARD => [
                t('What a nasty tackle by [player] leaves no choice to referee but to show him second yellow card. [player] is sent off.'),
                t('[player] argues to the referee after terrible tackle, but still it is s a second yellow card! [player] has to leave game.'),
                t('[player] is sent off with a second yellow card.'),
            ],
        ];
    }

    public function getTextsByType(string $type): array
    {
        $texts = $this->getTexts();

        return $texts[$type] ?? [];
    }

    public function getReportText(string $reportType, int $index): string
    {
        return $this->getTextsByType($reportType)[$index] ?? '';
    }
}
