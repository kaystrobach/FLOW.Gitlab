<?php

namespace KayStrobach\Gitlab\ViewHelpers\Widget\Controller;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Configuration\ConfigurationManager;


class MilestoneController extends \TYPO3\Fluid\Core\Widget\AbstractWidgetController {
	/**
	 * @var \TYPO3\Flow\Log\SystemLoggerInterface
	 * @Flow\Inject
	 */
	protected $logger;

	/**
	 * @var ConfigurationManager
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
	 * @var \Gitlab\Client
	 */
	protected $client = NULL;

	/**
	 *
	 */
	public function initializeAction() {
		$this->settings = $this->configurationManager->getConfiguration(
			ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
			'KayStrobach.Gitlab.Hosts.' . $this->widgetConfiguration['host']
		);
	}

	public function indexAction() {
		$milestones = $this->fetchDataFromGitlab($this->widgetConfiguration['project'], 'milestones');
		usort($milestones, function($a, $b) {return strcasecmp($a['due_date'], $b['due_date']);});
		$this->view->assign('config', $this->widgetConfiguration);
		$this->view->assign('settings', $this->settings);
		$this->view->assign('milestones', $milestones);
	}

	/**
	 * @param string $milestone
	 */
	public function showIssuesOfMileStoneAction($milestone = NULL) {
		$this->view->assign('milestone', $milestone);
		$this->view->assign('issues', $this->fetchDataFromGitlab($this->widgetConfiguration['project'], 'issues?milestone=' . urlencode($milestone)));
	}

	protected function fetchDataFromGitlab($projectId, $params = '') {
		$url = $this->settings['uri'] . '/api/v3/projects/' . $projectId . '/' . $params;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($curl,CURLOPT_CONNECTTIMEOUT,25);
		curl_setopt ($curl,CURLOPT_TIMEOUT,25);
		curl_setopt ($curl,CURLOPT_MAXREDIRS,10);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('PRIVATE-TOKEN: ' . $this->settings['token']));
		$result = json_decode(curl_exec($curl), TRUE);
		curl_close($curl);
		return $result;
	}
}