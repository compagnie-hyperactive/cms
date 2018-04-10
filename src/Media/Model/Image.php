<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 01/02/18
 * Time: 10:00
 */

namespace App\Media\Model;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

/**
 * Class Image
 * @package App\Entity
 *
 * @ORM\Table
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Image extends LocalMedia implements ImageInterface
{
    use Timestampable;
}