<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 28.05.15
 * Time: 16:00
 */

namespace KayStrobach\Gitlab\Controller;

use TYPO3\Flow\Annotations as Flow;


class UpdateController extends \TYPO3\Flow\Mvc\Controller\ActionController {
	/**
	 * @var \TYPO3\Flow\Configuration\ConfigurationManager
	 * @FLOW\Inject
	 */
	public $configurationManager;

	public function indexAction() {

	}

	public function importAction() {
		$settings = $this->configurationManager->getConfiguration(
			\TYPO3\Flow\Configuration\ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
			'TYPO3.Flow'
		);

		\TYPO3\Flow\Core\Booting\Scripts::executeCommand('gitlab:import', $settings);
		$this->redirect(
			'index',
			'Gitlab'
		);
	}
}