<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 08/02/18
 * Time: 12:01
 */

namespace App\Media\Twig;

use App\Media\ImageManager;
use App\Media\Model\ImageInterface;
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

    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return array(
            new \Twig_Function('imagePath', [$this, 'imagePath']),
        );
    }

    /**
     * @param ImageInterface $image
     * @return string
     */
    public function imagePath(ImageInterface $image)
    {
        return $this->imageManager->getPath($image);
    }
}