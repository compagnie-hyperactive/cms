<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 08/12/17
 * Time: 08:22
 */

namespace App\Event;

use App\Entity\Image;
use Symfony\Component\EventDispatcher\Event;

class ImageDownloadEvent extends Event
{
    /** @var Image  */
    private $image;

    /** @var File */
    private $file;

    /**
     * DocumentDownloadEvent constructor.
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * @return Image
     */
    public function getDocument()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setDocument(Image $image)
    {
        $this->image = $image;
    }

    public function getFile()
    {
        die(dump($this->image));

       // $this->file

        return $this->file;
    }
}
