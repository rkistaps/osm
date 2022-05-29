<?php

declare(strict_types=1);

namespace OSM\Frontend\Helpers;

use League\Plates\Template\Template;

class TemplateHelper
{
    private static ?string $latestFolderName = null;

    public static function rememberLatestFolderName(string $folderName)
    {
        self::$latestFolderName = $folderName;
    }

    public static function getFolderName(): ?string
    {
        return self::$latestFolderName;
    }

    public static function renderPartial(Template $template, string $view, array $params = [])
    {
        $template->insert(self::getFolderName() . '::' . $view, $params);
    }
}