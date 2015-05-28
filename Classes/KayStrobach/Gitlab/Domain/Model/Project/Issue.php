<?php
namespace KayStrobach\Gitlab\Domain\Model\Project;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "KayStrobach.Gitlab".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Issue {
	/**
	 * @var string
	 */
	protected $identifierOnRemoteSystem;

	/**
	 * @var \KayStrobach\Gitlab\Domain\Model\Project
	 * @ORM\ManyToOne(inversedBy="issues")
	 */
	protected $project;

	/**
	 * @var \KayStrobach\Gitlab\Domain\Model\Project\Milestone
	 * @ORM\ManyToOne(inversedBy="issues")
	 */
	protected $milestone;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $description;

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
	 * @return \KayStrobach\Gitlab\Domain\Model\Project
	 */
	public function getProject() {
		return $this->project;
	}

	/**
	 * @param \KayStrobach\Gitlab\Domain\Model\Project $project
	 */
	public function setProject($project) {
		$this->project = $project;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
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
	 * @return Milestone
	 */
	public function getMilestone() {
		return $this->milestone;
	}

	/**
	 * @param Milestone $milestone
	 */
	public function setMilestone($milestone) {
		$this->milestone = $milestone;
	}
}