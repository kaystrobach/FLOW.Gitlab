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
class Group {
	/**
	 * @var \KayStrobach\Gitlab\Domain\Model\Server
	 * @ORM\ManyToOne(inversedBy="groups")
	 */
	protected $server;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\KayStrobach\Gitlab\Domain\Model\Project>
	 * @ORM\OrderBy({"name" = "DESC"})
	 * @ORM\OneToMany(mappedBy="projectGroup")
	 */
	protected $projects;

	/**
	 *
	 */
	public function __construct() {
		$this->projects =  new \Doctrine\Common\Collections\ArrayCollection();
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
	 * @return \Doctrine\Common\Collections\Collection<\KayStrobach\Gitlab\Domain\Model\Project>
	 */
	public function getProjects() {
		return $this->projects;
	}

	/**
	 * @param \Doctrine\Common\Collections\Collection<\KayStrobach\Gitlab\Domain\Model\Project> $projects
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