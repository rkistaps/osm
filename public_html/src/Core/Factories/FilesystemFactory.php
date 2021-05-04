<?php

declare(strict_types=1);

namespace OSM\Core\Factories;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;

class FilesystemFactory
{
    public function build(): Filesystem
    {
        $adapter = new LocalFilesystemAdapter(APP_ROOT);

        return new Filesystem($adapter);
    }
}
