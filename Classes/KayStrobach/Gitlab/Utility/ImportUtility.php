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
	 * @var \KayStrobach\Gitlab\Domain\Repository\Project\IssueRepository
	 */
	protected $issueRepository;

	/**
	 * @Flow\Inject
	 * @var \KayStrobach\Gitlab\Domain\Repository\Project\MilestoneRepository
	 */
	protected $milestoneRepository;

	/**
	 * @Flow\Inject
	 * @var \KayStrobach\Gitlab\Domain\Repository\GroupRepository
	 */
	protected $groupRepository;

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
		$groups = $this->fetchUtility->fetchGroups($server);
		foreach($groups as $groupData) {
			$group = $this->groupRepository->findOneByServerAndRemoteIdentifier($server, $groupData['id']);
			if($group !== NULL) {
				$group->setName($groupData['name']);
				$group->setDescription($groupData['description']);
				$this->groupRepository->update($group);
			} else {
				$group = new Group();
				$group->setIdentifierOnRemoteSystem($groupData['id']);
				$group->setName($groupData['name']);
				$group->setDescription($groupData['description']);
				$group->setServer($server);
				$this->groupRepository->add($group);
			}
		}
	}

	public function importProjects(Server $server) {
		$projectsData = $this->fetchUtility->fetchProjects($server);
		foreach($projectsData as $projectData) {
			$project = $this->projectRepository->findOneByServerAndRemoteIdentifier($server, $projectData['id']);
			if($project !== NULL) {
				$project->setName($projectData['name']);
				$project->setDescription($projectData['description']);
				$project->setWebInterfaceUrl($projectData['web_url']);
				$project->setNamespace($projectData['namespace']['name']);
				$this->projectRepository->update($project);
			} else {
				$project = new Project();
				$project->setIdentifierOnRemoteSystem($projectData['id']);
				$project->setName($projectData['name']);
				$project->setDescription($projectData['description']);
				$project->setWebInterfaceUrl($projectData['web_url']);
				$project->setNamespace($projectData['namespace']['name']);
				$project->setServer($server);
				$this->projectRepository->add($project);
			}
		}
		return count($projectsData);
	}

	public function importMilestones(Project $project) {
		$milestones = $this->fetchUtility->fetchMilestones($project);
		foreach($milestones as $milestoneData) {
			$milestone = $this->milestoneRepository->findOneByProjectAndRemoteIdentifier($project, $milestoneData['id']);
			if($milestone !== NULL) {
				$milestone->setTitle($milestoneData['title']);
				$milestone->setDescription($milestoneData['description']);
				$milestone->setCreated(new \DateTime($milestoneData['created_at']));
				$milestone->setUpdated(new \DateTime($milestoneData['updated_at']));
				$milestone->setDue(new \DateTime($milestoneData['due_date']));
				$milestone->setState(new Project\Milestone\State($milestoneData['state']));
				$this->milestoneRepository->update($milestone);
			} else {
				$milestone = new Project\Milestone();
				$milestone->setIdentifierOnRemoteSystem($milestoneData['id']);
				$milestone->setTitle($milestoneData['title']);
				$milestone->setDescription($milestoneData['description']);
				$milestone->setCreated(new \DateTime($milestoneData['created_at']));
				$milestone->setUpdated(new \DateTime($milestoneData['updated_at']));
				$milestone->setDue(new \DateTime($milestoneData['due_date']));
				$milestone->setState(new Project\Milestone\State($milestoneData['state']));
				$milestone->setProject($project);
				$this->milestoneRepository->add($milestone);
			}
		}
		return count($milestones);
	}

	public function importIssues(Project $project) {
		/** @var \KayStrobach\Gitlab\Domain\Model\Project\Issue $issue */
		$issues = $this->fetchUtility->fetchIssues($project);
		foreach($issues as $issueData) {
			$issue = $this->issueRepository->findOneByProjectAndRemoteIdentifier($project, $issueData['id']);

			if($issueData['milestone'] === NULL) {
				$milestone = NULL;
			} else {
				$milestone = $this->milestoneRepository->findOneByProjectAndRemoteIdentifier($project, $issueData['milestone']['id']);
			}

			if($issue !== NULL) {
				$issue->setTitle($issueData['title']);
				$issue->setDescription($issueData['description']);
				$issue->setState(new Project\Issue\State($issueData['state']));
				$issue->setUpdated(new \DateTime($issueData['created_at']));
				$issue->setCreated(new \DateTime($issueData['updated_at']));
				$issue->setMilestone($milestone);
				$this->issueRepository->update($issue);
			} else {
				$issue = new Project\Issue();
				$issue->setIdentifierOnRemoteSystem($issueData['id']);
				$issue->setIssueId($issueData['iid']);
				$issue->setProject($project);
				$issue->setTitle($issueData['title']);
				$issue->setDescription($issueData['description']);
				$issue->setState(new Project\Issue\State($issueData['state']));
				$issue->setUpdated(new \DateTime($issueData['created_at']));
				$issue->setCreated(new \DateTime($issueData['updated_at']));
				$issue->setMilestone($milestone);
				$this->issueRepository->add($issue);
			}
		}
		return count($issues);
	}
}