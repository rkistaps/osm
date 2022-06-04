<?php

use OSM\Frontend\Helpers\Html;

$links = [
    [
        'href' => '/terms',
        'text' => _d('frontend', 'Terms and conditions'),
    ],
    [
        'href' => '/privacy',
        'text' => _d('frontend', 'Privacy'),
    ],
    [
        'href' => '/rules',
        'text' => _d('frontend', 'Rules'),
    ],
    [
        'href' => '/staff',
        'text' => _d('frontend', 'Staff'),
    ],
    [
        'href' => '/contact',
        'text' => _d('frontend', 'Contact'),
    ],
    [
        'href' => '/bugs',
        'text' => _d('frontend', 'Bug reports'),
    ],
];

$linkHtml = [];
foreach ($links as $link) {
    $linkHtmls[] = Html::a($link['text'], $link['href']);
}

echo Html::tag('div', implode(' - ', $linkHtmls), ['class' => 'links']);

?>
<div class="copyrights">
    Copyright &copy; 2011 - <?php echo date('Y') ?> OneSkill Manager
</div>
