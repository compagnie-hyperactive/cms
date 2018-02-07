<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 07/02/18
 * Time: 16:28
 */

namespace App\Form\Type;

use App\Form\DataTransformer\ImageToNumberTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddOrChooseImageType extends AbstractType
{
    const NAME = 'lch_add_choose_media';

    /** @var ImageToNumberTransformer  */
    private $transformer;

    /**
     * AddOrChooseImageType constructor.
     * @param ImageToNumberTransformer $imageToNumberTransformer
     */
    public function __construct(ImageToNumberTransformer $imageToNumberTransformer)
    {
        $this->transformer = $imageToNumberTransformer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->transformer);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected image does not exist',
        ));
    }

    /**
     * @return null|string
     */
    public function getParent()
    {
        return HiddenType::class;
    }

    /**
     * @inheritdoc
     */
    public function getBlockPrefix()
    {
        return static::NAME;
    }
}