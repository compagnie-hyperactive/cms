<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 28/02/18
 * Time: 12:38
 */

namespace App\Behavior;

use App\Model\Editorial\EditorialStatuses;
use Doctrine\ORM\Mapping as ORM;

trait Statusable {

	/**
	 * @var string $status
	 * @ORM\Column(type="string", length=255)
	 */
	protected $status = EditorialStatuses::DRAFT;

	/**
	 * @return string
	 */
	public function getStatus(): string {
		return $this->status;
	}

	/**
	 * @param string $status
	 * @return $this
	 */
	public function setStatus( string $status ): self {
		$this->status = $status;

		return $this;
	}


}