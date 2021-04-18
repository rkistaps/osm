<?php

declare(strict_types=1);

namespace OSM\Frontend\Components\SideMenu\Structures;

class SideMenuItem
{
    public bool $isActive = true;
    public string $icon;
    public string $text;
    public string $url;

    /** @var SideMenuItem[] */
    public array $subItems = [];

    /**
     * @param bool $isActive
     * @return SideMenuItem
     */
    public function setIsActive(bool $isActive): SideMenuItem
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @param string $icon
     * @return SideMenuItem
     */
    public function setIcon(string $icon): SideMenuItem
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @param string $text
     * @return SideMenuItem
     */
    public function setText(string $text): SideMenuItem
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param string $url
     * @return SideMenuItem
     */
    public function setUrl(string $url): SideMenuItem
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param SideMenuItem[] $subItems
     * @return SideMenuItem
     */
    public function setSubItems(array $subItems): SideMenuItem
    {
        $this->subItems = $subItems;
        return $this;
    }
}
