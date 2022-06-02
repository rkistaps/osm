<?php

declare(strict_types=1);

/** @var TeamLineup $lineup */

use OSM\Core\Models\TeamLineup;
use OSM\Core\Translations\Structures\Domains;
use OSM\Frontend\Helpers\Html;

?>
<?php Html::startForm('/lineup/save-tactics'); ?>
<div>
    <div class="form-group">
        <label for="tactic"><?php echo _d(Domains::DOMAIN_FRONTEND, 'Tactic') ?></label>
        <?php echo Html::select('tactic', TeamLineup::getAvailableTactics(), $lineup->tactic, ['class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <label for="passingStyle"><?php echo _d(Domains::DOMAIN_FRONTEND, 'Passing style') ?></label>
        <?php echo Html::select('passingStyle', TeamLineup::getAvailablePassingStyles(), $lineup->passingStyle, ['class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <label for="defensiveLine"><?php echo _d(Domains::DOMAIN_FRONTEND, 'Defensive line') ?></label>
        <?php echo Html::select('defensiveLine', TeamLineup::getAvailableDefensiveLines(), $lineup->defensiveLine, ['class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <label for="pressure"><?php echo _d(Domains::DOMAIN_FRONTEND, 'Pressure') ?></label>
        <?php echo Html::select('pressure', TeamLineup::getAvailablePressures(), $lineup->pressure, ['class' => 'form-control']) ?>
    </div>
</div>
<?php echo Html::submitButton('Save') ?>
<?php echo Html::endForm() ?>
