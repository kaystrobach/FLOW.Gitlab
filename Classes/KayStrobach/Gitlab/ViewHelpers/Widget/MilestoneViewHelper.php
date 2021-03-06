<?php
namespace KayStrobach\Gitlab\ViewHelpers\Widget;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Fluid".                 *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

class MilestoneViewHelper extends \TYPO3\Fluid\Core\Widget\AbstractWidgetViewHelper {

	/**
	 * @Flow\Inject
	 * @var \KayStrobach\Gitlab\ViewHelpers\Widget\Controller\MilestoneController
	 */
	protected $controller;

	/**
	 * Render this view helper
	 *
	 * @param string $project
	 * @param string $host
	 * @return string
	 */
	public function render($project, $host = 'default') {
		$response = $this->initiateSubRequest();
		return $response->getContent();
	}
}

?>