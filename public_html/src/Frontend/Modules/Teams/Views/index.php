<?php

use OSM\Frontend\Helpers\BoxHelper;
use OSM\Frontend\Helpers\Html;
use OSM\Frontend\Helpers\LinkHelper;
use OSM\Frontend\Modules\Teams\Models\TeamViewModel;
use OSM\Frontend\Templates\LayoutTypes;

$this->layout(LayoutTypes::TYPE_DEFAULT);

/** @var TeamViewModel $model */
/** @var bool $isOwner */

?>
<div class="row">
    <div class="col-7">
        <?php BoxHelper::start($model->team->name); ?>
        <div class="row">
            <div class="col-3"><?php echo _d('frontend', 'Name') ?>:</div>
            <div class="col-9 text-right"><?= $model->team->name ?></div>
        </div>
        <div class="row">
            <div class="col-3"><?php echo _d('frontend', 'Rating') ?>:</div>
            <div class="col-9 text-right"><?= $model->team->rating ?></div>
        </div>
        <div class="row">
            <div class="col-3"><?php echo _d('frontend', 'Manager') ?>:</div>
            <div class="col-9 text-right"><?= LinkHelper::user($model->user) ?></div>
        </div>
        <div class="row">
            <div class="col-3"><?php echo _d('frontend', 'Country') ?>:</div>
            <div class="col-9 text-right"><?= LinkHelper::country($model->country) ?></div>
        </div>
        <div class="row">
            <div class="col-3"><?php echo _d('frontend', 'League') ?>:</div>
            <div class="col-9 text-right"><?= LinkHelper::league($model->league) ?></div>
        </div>
        <?php echo BoxHelper::end() ?>
    </div>
    <div class="col-5">
        <?php BoxHelper::start(_d('frontend', 'Logo')); ?>
        <?php echo BoxHelper::end() ?>
        <?php BoxHelper::start(_d('frontend', 'Links')); ?>
        <div class="row">
            <div class="col-12">
                <?php echo Html::a(_f('Guestbook'), '/teams/' . $model->team->id . '/guestbook') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php echo Html::a(_f('Hall of fame'), '/teams/' . $model->team->id . '/hall-of-fame') ?>
            </div>
        </div>
        <?php if ($isOwner) { ?>
            <div class="row">
                <div class="col-12">
                    <?php echo Html::a(_f('Change name'), '/teams/change-name') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php echo Html::a(_f('Change fan club name'), '/teams/change-fan-club-name') ?>
                </div>
            </div>
        <?php } ?>
        <?php echo BoxHelper::end() ?>
    </div>
</div>

<div class="row">

</div>

