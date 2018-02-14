<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 14/02/18
 * Time: 11:04
 */

namespace App\Entity\User;

use App\User\Model\User as BaseUser;
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

}