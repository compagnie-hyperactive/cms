<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 28/02/18
 * Time: 17:44
 */

namespace App\Model\Editorial;


use Symfony\Component\Form\ChoiceList\Loader\ChoiceLoaderInterface;

class EditorialStatusesChoiceLoader implements ChoiceLoaderInterface {
	/**
	 * @inheritdoc
	 */
	public function loadChoiceList( $value = null ) {
		$reflectionClass = new \ReflectionClass(EditorialStatuses::class);
		return $reflectionClass->getConstants();
	}

	/**
	 * @inheritdoc
	 */
	public function loadChoicesForValues( array $values, $value = null ) {
		// TODO: Implement loadChoicesForValues() method.
	}

	/**
	 * @inheritdoc
	 */
	public function loadValuesForChoices( array $choices, $value = null ) {
		// TODO: Implement loadValuesForChoices() method.
	}
}