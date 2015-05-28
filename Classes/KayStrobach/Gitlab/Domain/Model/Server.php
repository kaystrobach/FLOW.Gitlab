<?php
namespace KayStrobach\Gitlab\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "KayStrobach.Gitlab".    *
 *                                                                        *
 *                                                                        */

use KayStrobach\Gitlab\Domain\Model\Group;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Server {
	/**
	 * @var \TYPO3\Flow\Configuration\ConfigurationManager
	 * @FLOW\Inject
	 */
	protected $configurationManager;

	/**
	 * The identifier of the server
	 *
	 * @var string
	 */
	protected $serverIdentifier;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\KayStrobach\Gitlab\Domain\Model\Group>
	 * @ORM\OrderBy({"name" = "DESC"})
	 * @ORM\OneToMany(mappedBy="server", cascade={"all"})
	 */
	protected $groups;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\KayStrobach\Gitlab\Domain\Model\Project>
	 * @ORM\OrderBy({"name" = "DESC"})
	 * @ORM\OneToMany(mappedBy="server", cascade={"all"})
	 */
	protected $projects;

	/**
	 *
	 */
	public function __construct() {
		$this->groups = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * @return string
	 */
	public function getServerIdentifier() {
		return $this->serverIdentifier;
	}

	/**
	 * @param string $serverIdentifier
	 */
	public function setServerIdentifier($serverIdentifier) {
		$this->serverIdentifier = $serverIdentifier;
	}

	/**
	 * @return mixed
	 */
	public function getGroups() {
		return $this->groups;
	}

	/**
	 * @param mixed $groups
	 */
	public function setGroups($groups) {
		$this->groups = $groups;
	}

	/**
	 * @param Group $group
	 */
	public function addGroup(Group $group) {
		$this->groups->add($group);
	}

	/**
	 * @param Group $group
	 */
	public function removeGroup(Group $group) {
		$this->groups->removeElement($group);
	}

	/**
	 * @return string
	 */
	public function getToken() {
		return $this->configurationManager->getConfiguration(
			\TYPO3\FLOW\Configuration\ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
			'KayStrobach.Gitlab.Hosts.' . $this->getServerIdentifier() . '.token'
		);
	}

	/**
	 * @return string
	 */
	public function getUri() {
		return $this->configurationManager->getConfiguration(
			\TYPO3\FLOW\Configuration\ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
			'KayStrobach.Gitlab.Hosts.' . $this->getServerIdentifier() . '.uri'
		);
	}

	/**
	 * @return bool
	 */
	public function isEnabled() {
		return $this->configurationManager->getConfiguration(
			\TYPO3\FLOW\Configuration\ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
			'KayStrobach.Gitlab.Hosts.' . $this->getServerIdentifier() . '.uri'
		) ? TRUE : FALSE;
	}

	/**
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getProjects() {
		return $this->projects;
	}

	/**
	 * @param \Doctrine\Common\Collections\Collection $projects
	 */
	public function setProjects($projects) {
		$this->projects = $projects;
	}

	/**
	 * @param Project $project
	 */
	public function addProject(Project $project) {
		$this->projects->add($project);
	}

	/**
	 * @param Project $project
	 */
	public function removeProject(Project $project) {
		$this->projects->removeElement($project);
	}
}