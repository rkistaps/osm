<?php

declare(strict_types=1);

/** @var TeamLineup $lineup */

use OSM\Core\Models\TeamLineup;
use OSM\Core\Translations\Structures\Domains;
use OSM\Frontend\Helpers\Html;

?>
<?php Html::startForm('/lineup/save-tactics'); ?>
<div>
    <div><?php echo _d(Domains::DOMAIN_FRONTEND, 'Tactic') ?></div>
    <div>
        <?php echo Html::select('tactic', [1 => 'test 1', 2 => 'test 2'], 2) ?>
    </div>
</div>



<?php echo Html::submitButton('Save') ?>
<?php echo Html::endForm() ?>
