<?php

declare(strict_types=1);

namespace OSM\Modules\Teams\Creation\Structures;

use OSM\Core\Helpers\Traits\FromArrayTrait;

class TeamCreationParams
{
    use FromArrayTrait;

    public int $userId;
    public int $countryId;
    public string $name;
    public bool $isDefault = false;

    /**
     * @param int $userId
     * @return TeamCreationParams
     */
    public function setUserId(int $userId): TeamCreationParams
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @param int $countryId
     * @return TeamCreationParams
     */
    public function setCountryId(int $countryId): TeamCreationParams
    {
        $this->countryId = $countryId;
        return $this;
    }

    /**
     * @param string $name
     * @return TeamCreationParams
     */
    public function setName(string $name): TeamCreationParams
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param bool $isDefault
     * @return TeamCreationParams
     */
    public function setIsDefault(bool $isDefault): TeamCreationParams
    {
        $this->isDefault = $isDefault;
        return $this;
    }
}
