<?php
namespace KayStrobach\Gitlab\Utility;

use KayStrobach\Gitlab\Domain\Model\Group;
use KayStrobach\Gitlab\Domain\Model\Project;
use KayStrobach\Gitlab\Domain\Model\Server;
use TYPO3\Flow\Annotations as Flow;


class ImportUtility {
	/**
	 * @FLOW\Inject
	 * @var \TYPO3\Flow\Configuration\ConfigurationManager
	 */
	protected $configurationManager;

	/**
	 * @Flow\Inject
	 * @var \KayStrobach\Gitlab\Domain\Repository\ServerRepository
	 */
	protected $serverRepository;

	/**
	 * @Flow\Inject
	 * @var \KayStrobach\Gitlab\Domain\Repository\ProjectRepository
	 */
	protected $projectRepository;

	/**
	 * @Flow\Inject
	 * @var \KayStrobach\Gitlab\Utility\FetchDataUtility
	 */
	protected $fetchUtility;

	public function importServers() {
		$serversFromSettings = $this->configurationManager->getConfiguration(
			\TYPO3\FLOW\Configuration\ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
			'KayStrobach.Gitlab.Hosts'
		);

		foreach($serversFromSettings as $key => $server) {
			$serverCount = $this->serverRepository->findByServerIdentifier($key)->count();
			if($serverCount === 0) {
				$newServer = new Server();
				$newServer->setServerIdentifier($key);
				$this->serverRepository->add($newServer);
			}
		}
	}

	public function importGroups(Server $server) {

	}

	public function importProjects(Server $server) {
		$projectsData = $this->fetchUtility->fetchProjects($server);
		print_r($projectsData);
		foreach($projectsData as $projectData) {
			$project = new Project();
			$project->setName($projectData['name']);
			$project->setDescription($projectData['description']);
			$project->setServer($server);
			$server->addProject($project);
		}
		$this->serverRepository->update($server);
	}

	public function importIssues(Project $project) {

	}
}