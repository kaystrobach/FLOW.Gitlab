<?php
namespace KayStrobach\Gitlab\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "KayStrobach.Gitlab".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class GitlabCommandController extends \TYPO3\Flow\Cli\CommandController {

	/**
	 * @FLOW\Inject
	 * @var \TYPO3\Flow\Configuration\ConfigurationManager
	 */
	protected $configurationManager;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * @Flow\Inject
	 * @var \KayStrobach\Gitlab\Domain\Repository\ServerRepository
	 */
	protected $serverRepository;

	/**
	 * @Flow\Inject
	 * @var \KayStrobach\Gitlab\Utility\ImportUtility
	 */
	protected $importUtility;

	/**
	 * starts the import from the configured gitlab instances
	 */
	public function importCommand() {
		$this->importUtility->importServers();
		$this->persistenceManager->persistAll();

		$servers = $this->serverRepository->findAll();
		foreach($servers as $server) {
			$this->importUtility->importGroups($server);
			$this->persistenceManager->persistAll();
			$this->importUtility->importProjects($server);
			$this->persistenceManager->persistAll();
		}
	}

	public function listCommand() {
		$serversFromSettings = $this->configurationManager->getConfiguration(
			\TYPO3\FLOW\Configuration\ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
			'KayStrobach.Gitlab.Hosts'
		);

		$table = array();
		foreach($serversFromSettings as $key => $server) {
			$uri = $this->configurationManager->getConfiguration(
				\TYPO3\FLOW\Configuration\ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
				'KayStrobach.Gitlab.Hosts.' . $key . '.uri'
			);
			$token = $this->configurationManager->getConfiguration(
				\TYPO3\FLOW\Configuration\ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
				'KayStrobach.Gitlab.Hosts.' . $key . '.token'
			);
			$enabled = $this->configurationManager->getConfiguration(
				\TYPO3\FLOW\Configuration\ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
				'KayStrobach.Gitlab.Hosts.' . $key . '.enabled'
			);
			$table[] = array(
				$key,
				$uri,
				$token,
				$enabled
			);
		}

		$this->output->outputTable(
			$table,
			array(
				'Key',
				'Server',
				'Token',
				'Enabled'
			)
		);
	}

}