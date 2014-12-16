<?php

namespace KayStrobach\Gitlab\ViewHelpers\Widget\Controller;

use TYPO3\Flow\Annotations as Flow;


class MilestoneController extends \TYPO3\Fluid\Core\Widget\AbstractWidgetController {
	/**
	 * @var \TYPO3\Flow\Log\SystemLoggerInterface
	 * @Flow\Inject
	 */
	protected $logger;

	/**
	 * @var \TYPO3\Flow\Configuration\ConfigurationManager
	 * @FLOW\Inject
	 */
	public $configurationManager;

	/**
	 * stores the settings
	 */
	protected $settings = array();

	/**
	 * @var null|array
	 */
	protected $debug = NULL;
	/**
	 *
	 */
	public function initializeAction() {

	}

	public function indexAction() {
		$this->view->assign('config',   $this->widgetConfiguration);
	}
}