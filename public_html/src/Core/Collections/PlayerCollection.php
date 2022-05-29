<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\Player;

/**
 * @method PlayerCollection filter(callable $callback = null)
 * @method Player firstWhere($key, $operator = null, $value = null)
 * @method Player[] all()
 */
class PlayerCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return Player::class;
    }

    public function getIds(): array
    {
        return $this->map(fn(Player $player) => $player->id)->all();
    }

    public function getByPosition(string $position): PlayerCollection
    {
        return $this->filter(fn(Player $player) => $player->position === $position);
    }

    public function removeByPosition(string $position, int $toRemove = null): PlayerCollection
    {
        $removed = 0;

        $collection = new PlayerCollection();
        foreach ($this->all() as $player) {
            if ($player->position === $position && (is_null($toRemove) || $removed < $toRemove)) {
                $removed++;
                continue;
            }

            $collection->add($player);
        }

        return $collection;
    }
}
