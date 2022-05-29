<?php

declare(strict_types=1);

use OSM\Core\Collections\TeamLineupPlayerCollection;
use OSM\Core\Models\Team;
use OSM\Core\Models\TeamLineup;
use OSM\Core\Translations\Structures\Domains;
use OSM\Frontend\Helpers\BoxHelper;
use OSM\Frontend\Helpers\Html;
use OSM\Frontend\Helpers\LinkHelper;
use OSM\Frontend\Templates\LayoutTypes;

$this->layout(LayoutTypes::TYPE_DEFAULT);

/** @var array|null $postPlayerIds */
/** @var Team $team */
/** @var TeamLineup $lineup */
/** @var TeamLineupPlayerCollection $lineupPlayers */
/** @var \OSM\Core\Collections\PlayerCollection $players */
/** @var \OSM\Core\Factories\GenericFactory $factory */

$selectedPlayerIds = $postPlayerIds ?? $lineupPlayers->getPlayerIds();

?>
<?php BoxHelper::start(_d(Domains::DOMAIN_FRONTEND, 'Lineup')) ?>
<?php Html::startForm('/lineup'); ?>
<table class="">
    <tr>
        <th>&nbsp;</th>
        <th><?=_d(Domains::DOMAIN_FRONTEND, "Pos.")?></th>
        <th><?=_d(Domains::DOMAIN_FRONTEND, "Player")?></th>
        <th><?=_d(Domains::DOMAIN_FRONTEND, "Age")?></th>
        <th><?=_d(Domains::DOMAIN_FRONTEND, "Skill")?></th>
        <th><?=_d(Domains::DOMAIN_FRONTEND, "Talent")?></th>
        <th><?=_d(Domains::DOMAIN_FRONTEND, "Energy")?></th>
        <th><?=_d(Domains::DOMAIN_FRONTEND, "Nat")?></th>
        <th>&nbsp;</th>
    </tr>
    <?php foreach ($players->all() as $player) { ?>
        <tr>
            <td><?php echo Html::checkbox('players[]', $player->id, in_array($player->id, $selectedPlayerIds)) ?></td>
            <td><?php echo $player->position ?></td>
            <td><?php echo LinkHelper::player($player) ?></td>
            <td><?php echo $player->age ?></td>
            <td><?php echo $player->skill ?></td>
            <td><?php echo $player->talent ?></td>
            <td><?php echo $player->energy ?></td>
            <td><?php echo $player->countryId ?></td>
        </tr>
    <?php } ?>
</table>
<?php echo Html::submitButton(_d(Domains::DOMAIN_FRONTEND, 'Save lineup'), 'save-lineup') ?>
<?php echo Html::endForm() ?>
<?php echo BoxHelper::end() ?>

<div class="row">
    <?php BoxHelper::start(_d(Domains::DOMAIN_FRONTEND, 'Tactic'), ['class' => 'box col-4']); ?>
        <?php echo $this->insert("_tactics", ['lineup' => $lineup]) ?>
    <?php echo BoxHelper::end() ?>

    <?php BoxHelper::start(_d(Domains::DOMAIN_FRONTEND, 'Substitutes'), ['class' => 'box col-4']); ?>
    <?php echo BoxHelper::end() ?>

    <?php BoxHelper::start(_d(Domains::DOMAIN_FRONTEND, 'Saved Tactics'), ['class' => 'box col-4']); ?>
    <?php echo BoxHelper::end() ?>
</div>