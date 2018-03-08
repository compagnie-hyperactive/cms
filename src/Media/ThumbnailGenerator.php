<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 25/11/17
 * Time: 17:05
 */

namespace App\Media;

use Symfony\Component\HttpFoundation\File\File;

class ThumbnailGenerator
{
    /**
     * Generate an thumbnail for the given file
     *
     * @param $path
     * @param $filename
     * @return bool|File
     */
    public function generateThumbnailFromImage($path, $filename) : ? File
    {
        if (extension_loaded('imagick')) {

            $file = new File($path.'/'.$filename);

            /**
             * Exportables parameters
             */
            $imageQuality = 100;
            $imageHeight = 100;
            $imageWidth = 100;
            $outputFormat = 'jpg';

            $imagick = new \Imagick($file->getPathname());

            $imagick->setImageFormat($outputFormat);
            $imagick->setCompression(\Imagick::COMPRESSION_JPEG);
            $imagick->setCompressionQuality($imageQuality);

            $imagick->thumbnailImage($imageHeight, $imageWidth, true, false);

            $path = $file->getPath();
            $thumbnailName = $this->generateThumbnailName($outputFormat);

            $imagick->writeImage( $path.'/'.$thumbnailName );

            return new File($path.'/'.$thumbnailName);
        }

        return false;
    }

    /**
     * @param string $extension
     * @return string
     */
    private function generateThumbnailName(string $extension) : string
    {
        return 'thumbnail-'.md5(uniqid()).'.'.$extension;
    }
}
