<?php

declare(strict_types=1);

namespace OSM\Modules\Players\Creation\Services;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use OSM\Core\Components\ArrayCache;
use OSM\Core\Factories\ArrayCacheFactory;
use OSM\Core\Models\PlayerFace;
use OSM\Modules\Players\Structures\PlayerFaceImage;

class PlayerFaceImageCreationService
{
    private const FILE_SYSTEM_PATH = APP_ROOT . '/public';
    private const WEB_PATH = '/assets/images/players/faces';

    private const IMAGE_PARTS_PATH = self::FILE_SYSTEM_PATH . '/assets/images/faces';

    private ImageManager $imageManager;
    private ArrayCache $arrayCache;

    public function __construct(
        ImageManager $imageManager,
        ArrayCacheFactory $arrayCacheFactory
    ) {
        $this->imageManager = $imageManager;
        $this->arrayCache = $arrayCacheFactory->getForClass(self::class);
    }

    public function getFaceImage(PlayerFace $face): PlayerFaceImage
    {
        $hash = $face->getHash();
        $cachedImage = $this->arrayCache->get($hash);
        if ($cachedImage) {
            return $cachedImage;
        }

        $playerFaceImage = new PlayerFaceImage($this->getWebPathFromHash($hash));

        $path = $this->getFilePathFromHash($hash);

        if (is_file($path)) {
            $this->arrayCache->set($hash, $playerFaceImage);

            return $playerFaceImage;
        }

        $image = $this->generateFaceImageFile($face);
        $image->save($path);

        return $playerFaceImage;
    }

    public function generateFaceImageFile(PlayerFace $face): Image
    {
        $image = $this->imageManager
            ->make(self::IMAGE_PARTS_PATH . '/face/seja' . $face->skinTone . '.png')
            ->insert(self::IMAGE_PARTS_PATH . '/shirts/krekls' . $face->shirtColor . '.png');

        if ($face->hairType) {
            $image
                ->insert(self::IMAGE_PARTS_PATH . '/hair/mati' . $face->hairType . '/mati' . $face->hairColor . '.png');
        }

        // todo add eyebrow type
        $image->insert(self::IMAGE_PARTS_PATH . '/eye-brows/uzacis1/uzacis' . $face->hairColor . '.png');

        $image->insert(self::IMAGE_PARTS_PATH . '/eyes/acis' . $face->eyeType . '/acis' . $face->eyeColor . '.png');
        $image->insert(self::IMAGE_PARTS_PATH . '/mouth/mute' . $face->mouthType . '/mute' . $face->skinTone . '.png');

        if ($face->facialHairType) {
            $image->insert(self::IMAGE_PARTS_PATH . '/facial-hair/usas' . $face->facialHairType . '/usas' . $face->hairColor . '.png');
        }

        return $image;
    }

    public function getFilePathFromHash(string $hash): string
    {
        return self::FILE_SYSTEM_PATH . $this->getWebPathFromHash($hash);
    }

    public function getWebPathFromHash(string $hash): string
    {
        return self::WEB_PATH . '/' . $hash . '.png';
    }
}
