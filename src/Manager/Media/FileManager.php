<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 08/02/18
 * Time: 11:27
 */

namespace App\Manager\Media;

use Symfony\Component\HttpFoundation\File\File;

class FileManager
{
    /**
     * Create a File object from a path
     *
     * @param string $path
     *
     * @return File
     */
    public function createFileFormPath(string $path)
    {
        return new File($path);
    }

    /**
     * Delete File from server
     *
     * @param File $file
     */
    public function deleteFile(File $file)
    {
        unlink($file);
    }

    /**
     * Delete File from server, based on its path
     *
     * @param string $path
     */
    public function deleteFileByPath(string $path)
    {
        $file = $this->createFileFormPath($path);

        $this->deleteFile($file);
    }

    /**
     * Upload a File
     *
     * @param File $file
     * @param $fileName
     *
     * @param $path
     */
    public function uploadFile(File $file, $fileName, $path)
    {
        $file->move(
            $path,
            $fileName
        );
    }
}