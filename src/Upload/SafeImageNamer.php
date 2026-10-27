<?php

namespace App\Upload;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

/**
 * Names uploaded images with a random name and an extension derived from the
 * server-detected MIME type, never from the client-supplied filename, so an
 * upload can't end up as an executable or HTML file under public/.
 *
 * @implements NamerInterface<object>
 */
class SafeImageNamer implements NamerInterface
{
    public const EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];

    public function name(object $object, PropertyMapping $mapping): string
    {
        return self::randomName($mapping->getFile($object));
    }

    public static function randomName(File $file): string
    {
        $extension = self::EXTENSIONS[$file->getMimeType()] ?? null;
        if (null === $extension) {
            throw new \InvalidArgumentException('Only JPEG, PNG, WebP and GIF images can be uploaded.');
        }

        return bin2hex(random_bytes(16)).'.'.$extension;
    }
}
