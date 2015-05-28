<?php
namespace KayStrobach\Gitlab\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "KayStrobach.Gitlab".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Project {

	/**
	 * @var string
	 */
	protected $identifierOnRemoteSystem;

	/**
	 * @var \KayStrobach\Gitlab\Domain\Model\Group
	 * @ORM\ManyToOne(inversedBy="projects")
	 */
	protected $projectGroup;

	/**
	 * @var \KayStrobach\Gitlab\Domain\Model\Server
	 * @ORM\ManyToOne(inversedBy="projects")
	 */
	protected $server;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\KayStrobach\Gitlab\Domain\Model\Project\Issue>
	 * @ORM\OrderBy({"title" = "DESC"})
	 * @ORM\OneToMany(mappedBy="project", cascade={"all"})
	 */
	protected $issues;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\KayStrobach\Gitlab\Domain\Model\Project\Milestone>
	 * @ORM\OrderBy({"due" = "DESC"})
	 * @ORM\OneToMany(mappedBy="project", cascade={"all"})
	 */
	protected $milestones;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $namespace;

	/**
	 * @var string
	 */
	protected $webInterfaceUrl = '';

	/**
	 * @return string
	 */
	public function getIdentifierOnRemoteSystem() {
		return $this->identifierOnRemoteSystem;
	}

	/**
	 * @param string $identifierOnRemoteSystem
	 */
	public function setIdentifierOnRemoteSystem($identifierOnRemoteSystem) {
		$this->identifierOnRemoteSystem = $identifierOnRemoteSystem;
	}

	/**
	 * @return Group
	 */
	public function getProjectGroup() {
		return $this->projectGroup;
	}

	/**
	 * @param Group $projectGroup
	 */
	public function setProjectGroup($projectGroup) {
		$this->projectGroup = $projectGroup;
	}

	/**
	 * @return Server
	 */
	public function getServer() {
		return $this->server;
	}

	/**
	 * @param Server $server
	 */
	public function setServer($server) {
		$this->server = $server;
	}

	/**
	 * @return mixed
	 */
	public function getIssues() {
		return $this->issues;
	}

	/**
	 * @param mixed $issues
	 */
	public function setIssues($issues) {
		$this->issues = $issues;
	}

	/**
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getMilestones() {
		return $this->milestones;
	}

	/**
	 * @param \Doctrine\Common\Collections\Collection $milestones
	 */
	public function setMilestones($milestones) {
		$this->milestones = $milestones;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getNamespace() {
		return $this->namespace;
	}

	/**
	 * @param string $namespace
	 */
	public function setNamespace($namespace) {
		$this->namespace = $namespace;
	}

	/**
	 * @return string
	 */
	public function getWebInterfaceUrl() {
		return $this->webInterfaceUrl;
	}

	/**
	 * @param string $webInterfaceUrl
	 */
	public function setWebInterfaceUrl($webInterfaceUrl) {
		$this->webInterfaceUrl = $webInterfaceUrl;
	}
}