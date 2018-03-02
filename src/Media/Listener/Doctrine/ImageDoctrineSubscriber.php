<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 08/02/18
 * Time: 11:21
 */

namespace App\Media\Listener\Doctrine;

use App\Entity\Media\Image;
use App\Media\ImageManager;
use App\Media\Model\ImageInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageDoctrineSubscriber implements EventSubscriber
{
    /** @var ImageManager  */
    private $imageManager;

    /**
     * ImageDoctrineSubscriber constructor.
     * @param ImageManager $imageManager
     */
    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function getSubscribedEvents()
    {
        return array(
            'postLoad',
            'prePersist',
//            'postPersist',
            'preUpdate',
//            'postUpdate',
//            'preRemove',
            'postRemove',
        );
    }

    /**
     * On postLoad, load an File object in the file's document attribute
     *
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        /** @var Image $media */
        if (false === ($media = $this->getImage($args))) {
            return;
        }

        // Transform file path in a File object
        $this->imageManager->handleFile($media);
    }

    /**
     * On PrePersist, upload the document file
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        /** @var ImageInterface $media */
        if (false === ($media = $this->getImage($args))) {
            return;
        }

        // Upload Document FileuploadImageFile
        $this->imageManager->uploadImageFile($media);
    }

    /**
     * On preUpdate, delete precedent file
     * then updload new file
     *
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        /** @var Image $media */
        if (false === ($media = $this->getImage($args))) {
            return;
        }

        $precedentFile = $args->getEntityChangeSet()['file'][0];

        // If get is different from null, the file has been modified
        if ($media->getFile() instanceof UploadedFile) {
            // Delete precedent File
            $this->imageManager->deletePrecedentFile($media, $precedentFile);

            // Upload Document File
            $this->imageManager->uploadImageFile($media);
        } else {
            if ($precedentFile instanceof File) {
                $precedentFile = $precedentFile->getFilename();
            }
            $media->setFile($precedentFile);
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        /** @var ImageInterface $image */
        if (false === ($image = $this->getImage($args))) {
            return;
        }

        $this->imageManager->deleteImageFile($image);
    }


    /**
     * @param LifecycleEventArgs $args
     *
     * @return bool|ImageInterface
     */
    private function getImage(LifecycleEventArgs $args)
    {
        /** @var ImageInterface|bool $media */
        if (false === ($media = $args->getObject()) instanceof ImageInterface) {
            return false;
        }

        return $media;
    }
}