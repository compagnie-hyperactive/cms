<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 21/03/18
 * Time: 16:32
 */

namespace App\Form\Type\Homepage;


use App\Entity\Site\Site;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomepageType extends AbstractType {
	const NAME = 'lch_homepage';


	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add('name', TextType::class)
		;
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults([
			'data_class' => Site::class
		]);
	}


	/**
	 * @inheritdoc
	 */
	public function getBlockPrefix() {
		return static::NAME;
	}
}