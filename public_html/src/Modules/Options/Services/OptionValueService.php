<?php

declare(strict_types=1);

namespace OSM\Modules\Options\Services;

use OSM\Core\Repositories\OptionRepository;
use OSM\Modules\Options\Repositories\OptionGroupRepository;

class OptionValueService
{
    private OptionRepository $repository;
    private OptionGroupRepository $groupRepository;

    private $optionValues = [];

    public function __construct(
        OptionGroupRepository $groupRepository,
        OptionRepository $repository
    ) {
        $this->repository = $repository;
        $this->groupRepository = $groupRepository;

        $this->initializeValues();
    }

    public function getOptionValue(string $option): string
    {
        return $this->optionValues[$option] ?? '';
    }

    private function initializeValues()
    {
        $options = $this->repository->findAll();
        foreach ($options->all() as $option) {
            $this->optionValues[$option->name] = $option->value;
        }

        foreach ($this->groupRepository->getOptionGroups() as $optionGroup) {
            foreach ($optionGroup->getOptionDefinitions() as $definition) {
                $this->optionValues[$definition->namey] = $this->values[$definition->name] ?? $definition->defaultValue;
            }
        }
    }
}
