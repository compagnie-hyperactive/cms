<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 01/02/18
 * Time: 10:00
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PrivateResource
 * @package App\Entity
 *
 * @ORM\Table
 * @ORM\Entity
 */
class PrivateResource
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
     * @return PrivateResource
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}