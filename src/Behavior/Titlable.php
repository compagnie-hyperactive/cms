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
	 * @ORM\Column(type="string", length=512)
	 */
	protected $title = "";

	/**
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * @param string $title
	 *
	 * @return $this
	 */
	public function setTitle( string $title ): self {
		$this->title = $title;

		return $this;
	}
}