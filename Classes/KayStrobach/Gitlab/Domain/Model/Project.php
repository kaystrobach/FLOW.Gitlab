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
	 * @ORM\OneToMany(mappedBy="project")
	 */
	protected $issues;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $description;

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


}