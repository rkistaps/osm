<?php

declare(strict_types=1);

use OSM\Core\Collections\TeamLineupPlayerCollection;
use OSM\Core\Models\Team;
use OSM\Core\Models\TeamLineup;
use OSM\Core\Translations\Structures\Domains;
use OSM\Frontend\Helpers\AssetManager;
use OSM\Frontend\Helpers\BoxHelper;
use OSM\Frontend\Helpers\FlagHelper;
use OSM\Frontend\Helpers\Html;
use OSM\Frontend\Helpers\LinkHelper;
use OSM\Frontend\Helpers\PlayerHelper;
use OSM\Frontend\Helpers\TemplateHelper;
use OSM\Frontend\Templates\LayoutTypes;

$this->layout(LayoutTypes::TYPE_DEFAULT);

$assetManager = AssetManager::get();
$assetManager->registerCssFile('/assets/new-src/css/players.css');

/** @var array|null $postPlayerIds */
/** @var Team $team */
/** @var TeamLineup $lineup */
/** @var TeamLineupPlayerCollection $lineupPlayers */
/** @var \OSM\Core\Collections\PlayerCollection $players */
/** @var \OSM\Core\Collections\CountryCollection $countries */
/** @var \OSM\Core\Factories\GenericFactory $factory */

$selectedPlayerIds = $postPlayerIds ?? $lineupPlayers->getPlayerIds();
?>
<?php BoxHelper::start(_d(Domains::DOMAIN_FRONTEND, 'Lineup')) ?>
<?php Html::startForm('/lineup'); ?>
<table class="" id="LineupTable">
    <tr>
        <th>&nbsp;</th>
        <th><?=_d(Domains::DOMAIN_FRONTEND, "Pos.")?></th>
        <th><?=_d(Domains::DOMAIN_FRONTEND, "Player")?></th>
        <th class="center"><?=_d(Domains::DOMAIN_FRONTEND, "Age")?></th>
        <th class="center"><?=_d(Domains::DOMAIN_FRONTEND, "Skill")?></th>
        <th class="center"><?=_d(Domains::DOMAIN_FRONTEND, "Talent")?></th>
        <th class="center"><?=_d(Domains::DOMAIN_FRONTEND, "Energy")?></th>
        <th class="center"><?=_d(Domains::DOMAIN_FRONTEND, "Nat")?></th>
        <th>&nbsp;</th>
    </tr>
    <?php foreach ($players->all() as $player) { ?>
        <?php
            $isInLineup = in_array($player->id, $selectedPlayerIds);
            $country = $countries->getForPlayer($player);
        ?>
        <tr class="<?= $isInLineup ? 'lineup' : '' ?> player">
            <td class="center"><?php echo Html::checkbox('players[]', $player->id, $isInLineup) ?></td>
            <td class="position pos-<?=$player->position?>"><div><?php echo $player->position ?></div></td>
            <td><?php echo LinkHelper::player($player) ?></td>
            <td class="center"><?php echo $player->age ?></td>
            <td class="center skill"><div><?php echo $player->skill ?></div></td>
            <td class="center"><?php echo PlayerHelper::getTalentStars($player) ?></td>
            <td>
                <div class='energyCont'>
                    <div class='energyFill' style='width:<?=$player->energy?>%'></div>
                    <div class='text'><?=$player->energy?>%</div>
                </div>
            </td>
            <td class="center"><?php echo FlagHelper::countryFlagLinkSmall($country, ['flagOptions' => ['class' => 'country']]) ?></td>
        </tr>
    <?php } ?>
</table>
<?php echo Html::div(
    Html::submitButton(_d(Domains::DOMAIN_FRONTEND, 'Save lineup'), 'save-lineup'),
    ['class' => 'center save-lineup']
) ?>
<?php echo Html::endForm() ?>
<?php echo BoxHelper::end() ?>

<div class="row">
    <?php BoxHelper::start(_d(Domains::DOMAIN_FRONTEND, 'Tactic'), ['class' => 'box col-4']); ?>
        <?php TemplateHelper::renderPartial( $this,"_tactics", ['lineup' => $lineup]) ?>
    <?php echo BoxHelper::end() ?>

    <?php BoxHelper::start(_d(Domains::DOMAIN_FRONTEND, 'Substitutes'), ['class' => 'box col-4']); ?>
    <?php echo BoxHelper::end() ?>

    <?php BoxHelper::start(_d(Domains::DOMAIN_FRONTEND, 'Saved Tactics'), ['class' => 'box col-4']); ?>
    <?php echo BoxHelper::end() ?>
</div>