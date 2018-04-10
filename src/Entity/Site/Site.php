<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 28/02/18
 * Time: 12:36
 */

namespace App\Entity\Site;


use App\Entity\Media\Image;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

/**
 * Class Site
 * @package App\Entity\Site
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Site {
	use Timestampable,
		Blameable;

	/**
	 * @var int $id
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var string $name
	 * @ORM\Column(type="string", length=512)
	 */
	protected $name;
	/**
	 * @var Image
	 * @ORM\OneToOne(targetEntity="App\Entity\Media\Image")
	 * @ORM\JoinColumn(nullable=true)
	 */
	protected $logo;
	/**
	 * @var string $name
	 * @ORM\Column(type="text")
	 */
	protected $tags;

	/**
	 * @return string
	 */
	public function getTags(): ? string {
		return $this->tags;
	}

	/**
	 * @param string $tags
	 *
	 * @return Site
	 */
	public function setTags( string $tags ): Site {
		$this->tags = $tags;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): ? string {
		return $this->name;
	}

	/**
	 * @param string $name
	 *
	 * @return Site
	 */
	public function setName( string $name ): Site {
		$this->name = $name;

		return $this;
	}

	/**
	 * @return Image
	 */
	public function getLogo(): ? Image {
		return $this->logo;
	}

	/**
	 * @param Image $logo
	 *
	 * @return Site
	 */
	public function setLogo( Image $logo ): Site {
		$this->logo = $logo;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getId(): ? int {
		return $this->id;
	}

}