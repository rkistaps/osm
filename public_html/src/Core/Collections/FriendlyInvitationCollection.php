<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\FriendlyInvitation;

class FriendlyInvitationCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return FriendlyInvitation::class;
    }
}
