<?php

declare(strict_types=1);

use OSM\Core\Helpers\NumberHelper;
use OSM\Core\Models\Country;
use OSM\Core\Models\Player;
use OSM\Core\Models\Team;
use OSM\Frontend\Helpers\AssetManager;
use OSM\Frontend\Helpers\BoxHelper;
use OSM\Frontend\Helpers\Html;
use OSM\Frontend\Helpers\LinkHelper;
use OSM\Frontend\Helpers\PlayerHelper;
use OSM\Frontend\Templates\LayoutTypes;
use OSM\Modules\Players\Structures\PlayerFaceImage;

$this->layout(LayoutTypes::TYPE_DEFAULT);

$assetManager = AssetManager::get();
$assetManager->registerCssFile('/assets/new-src/css/players.css');


/**
 * @var Player $player ;
 * @var PlayerFaceImage $face
 * @var Team $team ;
 * @var Country $country ;
 * @var bool $isOwner ;
 */

$title = $player->getFullName() . ' (#' . $player->id . ')';

?>
<div class="row">
    <div class="col-7">
        <?php
        BoxHelper::start($title, ['id' => 'player']); ?>
        <div class="row">
            <div class="col-5">
                <?= Html::img($face->imageUrl)?>
            </div>
            <div class="col-7">
                <div class="row">
                    <div class="skill"><?= $player->skill ?></div>
                </div>
                <div class="row">
                    <div class="col-12 center">
                        <?= PlayerHelper::getTalentStars($player) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6"><?= _f('Team') ?>:</div>
            <div class="col-6 right"><?= LinkHelper::team($team) ?> </div>
        </div>
        <div class="row">
            <div class="col-6"><?= _f('Nationality') ?></div>
            <div class="col-6 right">
                <?= LinkHelper::countryBoth($country, [], ['class' => 'country']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-6"><?= _f('Position') ?></div>
            <div class="col-6 right"><?= $player->getPositionLabel() ?></div>
        </div>
        <div class="row">
            <div class="col-6"><?= _f('Speciality') ?>:</div>
            <div class="col-6 right"><?= $player->getSpecialityLabel() ?> </div>
        </div>
        <div class="row">
            <div class="col-6"><?= _f('Character') ?>:</div>
            <div class="col-6 right"><?= $player->getCharacterLabel() ?> </div>
        </div>
        <div class="row">
            <div class="col-6"><?= _f('Salary') ?>:</div>
            <div class="col-6 right"><?= NumberHelper::formatMoney($player->salary, 0) ?> </div>
        </div>
        <?= BoxHelper::end(); ?>
    </div>
    <div class="col-5">Right column</div>
</div>
