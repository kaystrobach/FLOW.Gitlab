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
	protected $configurationManager;

	/**
	 * @var \TYPO3\Flow\Cache\Frontend\FrontendInterface
	 * @FLOW\Inject
	 */
	protected $cache;

	public function indexAction() {
		if($this->cache->get('dataUpdated') == 1) {
			$this->redirect('index', 'Gitlab');
		}
	}

	public function importAction() {
		$settings = $this->configurationManager->getConfiguration(
			\TYPO3\Flow\Configuration\ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
			'TYPO3.Flow'
		);

		\TYPO3\Flow\Core\Booting\Scripts::executeCommand('gitlab:import', $settings);

		$this->cache->set('dataUpdated', 1);

		$this->redirect(
			'index',
			'Gitlab'
		);
	}
}