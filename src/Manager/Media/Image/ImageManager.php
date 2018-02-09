<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 08/02/18
 * Time: 11:26
 */

namespace App\Manager\Media\Image;

use App\Entity\Media\Image;
use App\Manager\Media\FileManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageManager
{
    /** @var FileManager  */
    private $fileManager;

    /** @var string  */
    private $image_directory;

    /** @var string  */
    private $project_dir;

    /**
     * DocumentManager constructor.
     * @param FileManager $fileManager
     * @param string $projectDir
     * @param string $image_directory
     */
    public function __construct(
        FileManager $fileManager,
        $projectDir,
        $image_directory
    )
    {
        $this->fileManager = $fileManager;
        $this->project_dir = $projectDir.'/public';
        $this->image_directory = $image_directory;
    }

    /**
     * Upload a document on the server
     * - Generate a unique name
     * - Upload the file
     *
     * @param Image $media
     */
    public function uploadImageFile(Image $media)
    {
        /** @var UploadedFile $file */
        $file = $media->getFile();

        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $media->setFile($fileName);

        $path = $this->getRelativePath();
        $media->setpath($path);

        $this->fileManager->uploadFile($file, $fileName, $this->project_dir.$path);
    }

    /**
     * If document's file attribute is a string, transform it in a File object
     *
     * @param Image $media
     */
    public function handleFile(Image $media)
    {
        if (true === is_string($media->getFile())) {
            $filePath = $this->project_dir.$media->getpath().'/'.$media->getFile();

            $media->setFile($this->fileManager->createFileFormPath($filePath));
        }
    }

    /**
     * Delete precedent file
     *
     * @param Image $media
     * @param $precedentFile
     */
    public function deletePrecedentFile(Image $media, $precedentFile)
    {
        $filePath = $this->project_dir.$media->getpath().'/'.$precedentFile;

        $this->fileManager->deleteFileByPath($filePath);
    }

    /**
     * @param Image $media
     * @return string
     */
    public function getPath(Image $media)
    {
        $this->handleFile($media);

        return $media->getPath().'/'.$media->getFile()->getFilename();
    }

    /**
     * Generate relative path to store file & thumbnail
     *
     * @return string
     */
    private function getRelativePath()
    {
        $date = new \DateTime();
        $path = $this->image_directory.'/'.$date->format('Y/m');

        return $path;
    }
}