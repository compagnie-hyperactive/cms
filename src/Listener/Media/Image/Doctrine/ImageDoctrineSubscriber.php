<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 08/02/18
 * Time: 11:21
 */

namespace App\Listener\Media\Image\Doctrine;

use App\Entity\Media\Image;
use App\Manager\Media\Image\ImageManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageDoctrineSubscriber implements EventSubscriber
{
    /** @var ImageManager  */
    private $imageManager;

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
//            'postRemove',
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
     * On prepersist, upload the document file
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        /** @var Image $media */
        if (false === ($media = $this->getImage($args))) {
            return;
        }

        // Upload Document File
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

    /**
     * @param LifecycleEventArgs $args
     *
     * @return bool|Image
     */
    private function getImage(LifecycleEventArgs $args)
    {
        /** @var Image|bool $image */
        if (false === ($media = $args->getObject()) instanceof Image) {
            return false;
        }

        return $media;
    }
}