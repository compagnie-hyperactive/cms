<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 14/02/18
 * Time: 11:04
 */

namespace App\Entity\User;

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Lch\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package App\Entity\User
 *
 * @ORM\Table
 * @ORM\Entity
 */
class User extends BaseUser
{
	use Timestampable;

}