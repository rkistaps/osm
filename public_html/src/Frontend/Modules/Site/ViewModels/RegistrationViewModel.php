<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Site\ViewModels;

use OSM\Frontend\Core\Abstracts\AbstractViewModel;

class RegistrationViewModel extends AbstractViewModel
{
    public string $username = '';
    public string $password = '';
    public string $passwordAgain = '';
    public string $teamName = '';
    public int $countryId = 0;
    public int $championshipId = 0;
}
