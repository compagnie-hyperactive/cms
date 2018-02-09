<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 08/12/17
 * Time: 08:22
 */

namespace App\Event\Media\Image;

use App\Entity\Media\Image;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\File\File;

class ImageDownloadEvent extends Event
{
    /** @var Image  */
    private $image;

    /** @var File */
    private $file;

    /** @var string */
    private $filename;

    /**
     * DocumentDownloadEvent constructor.
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        $this->setImage($image);
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setImage(Image $image)
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
