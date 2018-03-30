<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 30/03/18
 * Time: 11:31
 */

namespace App\Media\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class LocalMedia
 * @package App\Media\Model
 *
 * @ORM\Table
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
abstract class LocalMedia implements LocalMediaInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $title the page item title
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    protected $file;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $path;

    /**
     * @var string
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    protected $thumbnail;

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->title;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @inheritdoc
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @inheritdoc
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @inheritdoc
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @inheritdoc
     */
    public function setPath(string $path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnailName
     * @return self
     */
    public function setThumbnail(string $thumbnailName)
    {
        $this->thumbnail = $thumbnailName;
        return $this;
    }
}