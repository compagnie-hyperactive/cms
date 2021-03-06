<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 07/02/18
 * Time: 16:11
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Media\Image;

/**
 * Class Event
 * @ORM\Table
 * @ORM\Entity
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title the page item title
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var Image
     * @ORM\ManyToOne(targetEntity="App\Entity\Media\Image")
     * @ORM\JoinColumn(nullable=true)
     */
    private $headImage;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * @param bool $published
     * @return $this
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Image
     */
    public function getHeadImage()
    {
        return $this->headImage;
    }

    /**
     * @param Image $headImage
     * @return self
     */
    public function setHeadImage(Image $headImage)
    {
        $this->headImage = $headImage;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Article
     */
    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }


}