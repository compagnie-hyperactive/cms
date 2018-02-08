<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 08/02/18
 * Time: 12:01
 */

namespace App\Twig\Media\Image;


use App\Entity\Image;
use App\Manager\Media\ImageManager;
use Twig\Extension\AbstractExtension;

class ImageExtension extends AbstractExtension
{
    /** @var ImageManager  */
    private $imageManager;

    /**
     * ImageExtension constructor.
     * @param ImageManager $imageManager
     */
    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_Function('imagePath', [$this, 'imagePath']),
        );
    }

    public function imagePath(Image $image)
    {
        return $this->imageManager->getPath($image);
    }
}