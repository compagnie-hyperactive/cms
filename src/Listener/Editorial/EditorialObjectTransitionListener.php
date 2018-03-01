<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 28/02/18
 * Time: 18:07
 */

namespace App\Listener\Editorial;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\GuardEvent;

class EditorialObjectTransitionListener implements EventSubscriberInterface {

	public function gardDraft(GuardEvent $event) {

	}

	public function gardPublish(GuardEvent $event) {

	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return array(
			'workflow.editorial.guard.draft' => ['guardDraft'],
			'workflow.editorial.guard.publish' => ['guardPublish'],
		);
	}
}