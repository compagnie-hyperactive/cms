<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 01/02/18
 * Time: 09:32
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Event
 * @ORM\Table
 * @ORM\Entity
 */
class Event
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
     * @var \DateTime the event date
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var Image
     * @ORM\ManyToOne(targetEntity="App\Entity\Image")
     */
    private $headBandImage;

    public function __construct()
    {
        $this->date = new \DateTime();
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
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return Event
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return Image
     */
    public function getHeadBandImage()
    {
        return $this->headBandImage;
    }

    /**
     * @param Image $headBandImage
     * @return Event
     */
    public function setHeadBandImage(Image $headBandImage): Event
    {
        $this->headBandImage = $headBandImage;
        return $this;
    }
}