<?php

/** @var User $user */

/** @var Team|null $team */

/** @var Country|null $country */

use OSM\Core\Helpers\NumberHelper;
use OSM\Core\Models\Country;
use OSM\Core\Models\Team;
use OSM\Core\Models\User;
use OSM\Frontend\Helpers\Html;
use OSM\Frontend\Helpers\LinkHelper;

?>

<div id='overview'>
    <div id='budget'>
        <?= $team ? _d("frontend", "Team budget") . ': ' . NumberHelper::formatMoney($team->money) : '' ?>
    </div>
    <div class='info'>
        <div class='big'>
            <?php if ($country) { ?>
                <div class='line'>
                    <span class='label'><?= _d("frontend", "Country") ?>:</span>
                    <?= LinkHelper::country($country) ?>
                </div>
            <?php } ?>
            <div class='line'>
                <span class='label'><?= _d("frontend", "Manager") ?>:</span>
                <?= LinkHelper::user($user, ['class' => 'manager']) ?>
            </div>
            <?php if ($team) { ?>
                <div class='line'>
                    <span class='label'><?= _d("frontend", "Team") ?>:</span>
                    <?= LinkHelper::team($team) ?>
                </div>
            <?php } ?>
        </div>
        <div class='small'>
            <div class='line'>
                <span class='label'><?= _d("frontend", "League") ?>:</span>
                ???
            </div>
            <div class='line'>
                <span class='label'><?= _d("frontend", "Phoenicians") ?>:</span>
                ???
                <?= Html::a(_d("frontend", "Buy"), '/supporter', ['class' => 'mamanger']) ?> -
                <?= Html::a(_d("frontend", "Earn"), '/super-rewards', ['class' => 'mamanger']) ?> -
            </div>
            <?php if ($team) { ?>
                <div class='line'>
                    <span class='label'><?= _d("frontend", "Stadium") ?>:</span>
                    <?= Html::a(str_replace("[seats]", number_format($team->stadiumSize), _d("frontend", "[seats] seats")), '/facilities') ?>
                </div>
                <div class='line'>
                    <span class='label'><?= _d("frontend", "Fans") ?>:</span>
                    <?= number_format($team->supporters) ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
