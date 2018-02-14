<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 08/12/17
 * Time: 08:22
 */

namespace App\Media\Event\Image;

use App\Media\Model\ImageInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\File\File;

class ImageDownloadEvent extends Event
{
    /** @var ImageInterface  */
    private $image;

    /** @var File */
    private $file;

    /** @var string */
    private $filename;

    /**
     * DocumentDownloadEvent constructor.
     * @param ImageInterface $image
     */
    public function __construct(ImageInterface $image)
    {
        $this->setImage($image);
    }

    /**
     * @return ImageInterface
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param ImageInterface $image
     */
    public function setImage(ImageInterface $image)
    {
        $this->image = $image;
        $this->file = $image->getFile();
        $this->filename = $image->getTitle();
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->filename;
    }
}
