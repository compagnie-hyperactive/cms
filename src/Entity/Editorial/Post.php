<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 28/02/18
 * Time: 12:36
 */

namespace App\Entity\Editorial;

use App\Behavior\Statusable;
use App\Behavior\Titlable;
use App\Entity\Media\Image;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Lch\SeoBundle\Behaviour\Seoable;
use Lch\SeoBundle\Model\OpenGraph;
use Lch\SeoBundle\Model\SeoInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Post
 * @package App\Entity\Editorial
 *
 * @ORM\Table
 * @ORM\Entity
 * @UniqueEntity("slug")
 */
class Post implements SeoInterface {
	use Timestampable,
		Blameable,
		Titlable,
		Statusable,
		Seoable;

	/**
	 * @var int $id
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var Image
	 * @ORM\ManyToOne(targetEntity="App\Entity\Media\Image")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $headImage;

	/**
	 * @return Image
	 */
	public function getHeadImage() {
		return $this->headImage;
	}

	/**
	 * @param Image $headImage
	 *
	 * @return Post
	 */
	public function setHeadImage( Image $headImage ): Post {
		$this->headImage = $headImage;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @inheritdoc
	 */
	public function getSluggableFields() {
		return [
			'title'
		];
	}

	/**
	 * @return string the route name to generate detail page URL
	 */
	public function getRouteName() {
		return "app_post_show";
	}

	/**
	 * @return array all fields needed to create a matching entity route, on a key => value basis
	 * key is the route placeholder name, value the entity field linked
	 */
	public function getRouteFields() {
		return ['slug' => 'slug'];
	}

	/**
	 * @return string the default title value to use if title not set on entity saving
	 */
	public function getSeoTitleDefaultValue() {
		return $this->title;
	}

	/**
	 * @return OpenGraph $openGraph
	 */
	public function getOpenGraphData() {
		$openGraph = new OpenGraph();
		$openGraph->setTitle($this->seoTitle);
		$openGraph->setType("Solution");
		$openGraph->setDescription($this->seoDescription);

		if($this->headImage instanceof Image) {
			$imageData = explode('/public', $this->getHeadImage()->getFile());
			$openGraph->setImage(array_pop($imageData));
		}

		return $openGraph;
	}
}