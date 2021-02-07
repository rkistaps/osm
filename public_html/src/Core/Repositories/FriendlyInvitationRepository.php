<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\FriendlyInvitationCollection;
use OSM\Core\Models\FriendlyInvitation;

/**
 * @method FriendlyInvitation|null findById(int $id)
 */
class FriendlyInvitationRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'friendly_invitations';
    }

    protected function getModelClassName(): string
    {
        return FriendlyInvitation::class;
    }

    protected function getCollectionClassName(): string
    {
        return FriendlyInvitationCollection::class;
    }
}
