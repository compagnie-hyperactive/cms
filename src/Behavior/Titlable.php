<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 28/02/18
 * Time: 12:38
 */

namespace App\Behavior;

use Doctrine\ORM\Mapping as ORM;

trait Titlable {

	/**
	 * @var string $title
	 * @ORM\Column(type="string")
	 */
	protected $title;
}