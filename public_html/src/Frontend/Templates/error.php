<?php

use OSM\Frontend\Helpers\Html;
use OSM\Frontend\Modules\Site\ViewModels\ErrorViewModel;
use OSM\Frontend\Templates\LayoutTypes;

/** @var ErrorViewModel $error */

$this->layout(LayoutTypes::TYPE_DEFAULT);

?>

<div class="page-wrap d-flex flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <span class="display-1 d-block"><?php echo $error->code ?></span>
                <div class="mb-4 lead"><?php echo $error->title ?></div>
                <?php echo Html::a(_f('Back to Home'), '/news', ['class' => 'btn btn-link']) ?>
            </div>
        </div>
    </div>
</div>

