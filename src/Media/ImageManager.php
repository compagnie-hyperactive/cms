<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 08/02/18
 * Time: 11:26
 */

namespace App\Media;

use App\Media\Model\ImageInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageManager
{
    /** @var FileManager  */
    private $fileManager;

    /** @var ThumbnailGenerator */
    private $thumbnailGenerator;

    /** @var string  */
    private $image_directory;

    /** @var string  */
    private $project_dir;

    /**
     * DocumentManager constructor.
     * @param FileManager $fileManager
     * @param ThumbnailGenerator $thumbnailGenerator
     * @param string $projectDir
     * @param string $image_directory
     */
    public function __construct(
        FileManager $fileManager,
        ThumbnailGenerator $thumbnailGenerator,
        $projectDir,
        $image_directory
    )
    {
        $this->fileManager = $fileManager;
        $this->thumbnailGenerator = $thumbnailGenerator;
        $this->project_dir = $projectDir.'/public';
        $this->image_directory = $image_directory;
    }

    /**
     * Upload a document on the server
     * - Generate a unique name
     * - Upload the file
     *
     * @param ImageInterface $media
     */
    public function uploadImageFile(ImageInterface $media)
    {
        /** @var UploadedFile $file */
        $file = $media->getFile();

        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $media->setFile($fileName);

        $path = $this->generateRelativePath();
        $media->setpath($path);

        $this->fileManager->uploadFile($file, $fileName, $this->project_dir.$path);

        // Generate thumbnail
        $thumbnailFile = $this->thumbnailGenerator->generateThumbnailFromImage($this->project_dir.$path, $fileName);
        if ($thumbnailFile instanceof File) {
            $media->setThumbnail($thumbnailFile->getFilename());
        }
    }

    /**
     * If document's file attribute is a string, transform it in a File object
     *
     * @param ImageInterface $media
     */
    public function handleFile(ImageInterface $media)
    {
        if (true === is_string($media->getFile())) {
            $filePath = $this->project_dir.$media->getpath().'/'.$media->getFile();

            $media->setFile($this->fileManager->createFileFormPath($filePath));
        }
    }

    /**
     * Delete precedent file
     *
     * @param ImageInterface $media
     * @param string $filename
     */
    public function delete(ImageInterface $media, $filename)
    {
        $filePath = $this->project_dir.$media->getpath().'/';

        $this->fileManager->deleteFileByPath($filePath.'/'.$filename);

        // Delete thumbnail
        $this->deleteThumbnail($media);
    }

    /**
     * @param ImageInterface $media
     * @return string
     */
    public function getPath(ImageInterface $media)
    {
        $this->handleFile($media);

        return $media->getPath().'/'.$media->getFile()->getFilename();
    }

    /**
     * @param ImageInterface $media
     */
    public function deleteImageFile(ImageInterface $media)
    {
        $this->fileManager->deleteFile($media->getFile());
    }

    public function deleteThumbnail(ImageInterface $media)
    {
        $filePath = $this->project_dir.$media->getpath().'/';

        $this->fileManager->deleteFileByPath($filePath.$media->getThumbnail());
    }

    /**
     * Generate relative path to store file
     *
     * @return string
     */
    private function generateRelativePath()
    {
        $date = new \DateTime();
        $path = $this->image_directory.'/'.$date->format('Y/m');

        return $path;
    }
}