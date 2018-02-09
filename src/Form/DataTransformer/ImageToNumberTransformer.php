<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 07/02/18
 * Time: 16:31
 */

namespace App\Form\DataTransformer;

use App\Entity\Media\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ImageToNumberTransformer implements DataTransformerInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Image $image
     * @return integer
     */
    public function transform($image)
    {
        if (null === $image) {
            return '';
        }

        return $image->getId();
    }

    public function reverseTransform($imageNumber)
    {
        if (null === $imageNumber) {
            return null;
        }

        $image = $this->em
            ->getRepository(Image::class)
            ->findOneBy(['id' => $imageNumber])
        ;

        if (null === $image) {
            throw new TransformationFailedException(sprintf(
                'An image with id "%s" does not exist!',
                $imageNumber
            ));
        }

        return $image;
    }
}