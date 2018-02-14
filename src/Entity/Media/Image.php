<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 01/02/18
 * Time: 10:00
 */

namespace App\Entity\Media;

use App\Behavior\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use App\Media\Model\Image as BaseImage;

/**
 * Class Image
 * @package App\Entity
 *
 * @ORM\Table
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Image extends BaseImage
{

}