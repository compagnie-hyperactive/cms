<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 30/03/18
 * Time: 11:37
 */

namespace App\Media\Model;


interface LocalMediaInterface
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @return integer
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     * @return ImageInterface
     */
    public function setTitle(string $title);

    /**
     * @return mixed
     */
    public function getFile();

    /**
     * @param $file
     * @return ImageInterface
     */
    public function setFile($file);

    /**
     * @return string
     */
    public function getPath();

    /**
     * @param string $path
     * @return ImageInterface
     */
    public function setPath(string $path);

    /**
     * @return string
     */
    public function getThumbnail();

    /**
     * @param string $thumbnailName
     * @return ImageInterface
     */
    public function setThumbnail(string $thumbnailName);
}