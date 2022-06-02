<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Lineup\Structures;

use OSM\Frontend\Helpers\RequestHelper;
use Psr\Http\Message\ServerRequestInterface;

class SaveTacticsParameters
{
    public string $tactic = '';
    public string $passingStyle = '';
    public string $defensiveLine = '';
    public string $pressure = '';

    public static function fromRequest(ServerRequestInterface $request): SaveTacticsParameters
    {
        $params = new SaveTacticsParameters();

        $params->tactic = RequestHelper::getPost($request, 'tactic');
        $params->passingStyle = RequestHelper::getPost($request, 'passingStyle');
        $params->defensiveLine = RequestHelper::getPost($request, 'defensiveLine');
        $params->pressure = RequestHelper::getPost($request, 'pressure');

        return $params;
    }
}