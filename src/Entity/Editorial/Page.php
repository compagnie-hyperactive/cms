<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 28/02/18
 * Time: 12:35
 */

namespace App\Entity\Editorial;

use App\Behavior\Statusable;
use App\Behavior\Titlable;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

/**
 * Class Page
 * @package App\Entity\Editorial
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Page {
	use Timestampable,
		Blameable,
		Titlable,
		Statusable;

	/**
	 * @var int $id
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}
}