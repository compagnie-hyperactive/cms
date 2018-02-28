<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 28/02/18
 * Time: 12:35
 */

namespace App\Entity\Page;

use App\Behavior\Titlable;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

/**
 * Class Page
 * @package App\Entity\Page
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Page {
	use Timestampable,
		Blameable,
		Titlable;

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
}