<?php

declare(strict_types=1);

namespace OSM\Console\Commands;

use OSM\Core\Interfaces\ModelDataHydratorInterface;
use OSM\Core\Repositories\CountryRepository;
use TheApp\Components\CommandRunner;
use TheApp\Interfaces\CommandConfiguratorInterface;

class SiteCommandConfigurator implements CommandConfiguratorInterface
{
    public function configureCommands(CommandRunner $commandRunner)
    {
        $commandRunner->addCommand('test', function (CountryRepository $repository, ModelDataHydratorInterface $hydrator) {
            $countries = $repository->findAll();

            var_dump($countries);

            $lv = $repository->findOne(['short_name' => 'lv']);
            var_dump($lv);

            $countries = $countries->all();
            $data = $hydrator->extract($countries[0]);
            dd($data);
        });
    }
}
