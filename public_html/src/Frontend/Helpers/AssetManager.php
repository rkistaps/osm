<?php

declare(strict_types=1);

namespace OSM\Frontend\Helpers;

use TheApp\Apps\App;

class AssetManager
{
    public const LOCATION_HEAD = 'head';
    public const LOCATION_BODY = 'body';

    public const AVAILABLE_LOCATIONS = [
        self::LOCATION_BODY,
        self::LOCATION_HEAD,
    ];

    private array $jsFiles = [];
    private array $cssFiles = [];

    public static function get(): AssetManager
    {
        return App::getContainer()->get(AssetManager::class);
    }

    public function registerJsFile(string $file, string $location = self::LOCATION_BODY): AssetManager
    {
        if (!isset($this->jsFiles[$location])) {
            $this->jsFiles[$location] = [];
        }

        $this->jsFiles[$location][] = $file;

        return $this;
    }

    public function registerCssFile(string $file, string $location = self::LOCATION_HEAD): AssetManager
    {
        if (!isset($this->cssFiles[$location])) {
            $this->cssFiles[$location] = [];
        }

        $this->cssFiles[$location][] = $file;

        return $this;
    }

    protected function getJsFilesForLocation(string $location): array
    {
        return $this->jsFiles[$location] ?? [];
    }

    protected function getCssFilesForLocation(string $location): array
    {
        return $this->cssFiles[$location] ?? [];
    }

    public function renderJsAssets(string $location = self::LOCATION_BODY): string
    {
        return implode(PHP_EOL,
            array_map(
                fn($filePath) => Html::tag('script', '', ['src' => $filePath]),
                $this->getJsFilesForLocation($location)
            )
        );
    }

    public function renderCssAssets(string $location = self::LOCATION_HEAD): string
    {
        return implode(PHP_EOL,
            array_map(
                fn($filePath) => Html::tag('link', '', ['rel' => 'stylesheet', 'type' => 'text/css', 'href' => $filePath]),
                $this->getCssFilesForLocation($location)
            )
        );
    }


    public function renderRegisteredAssets(string $location = self::LOCATION_BODY): string
    {
        $assets = [
            $this->renderJsAssets($location),
            $this->renderCssAssets($location),
        ];

        return implode(PHP_EOL, $assets);
    }
}
