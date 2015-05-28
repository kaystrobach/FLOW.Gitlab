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
class Milestone {
	/**
	 * @Flow\Inject
	 * @var \KayStrobach\Gitlab\Domain\Repository\Project\IssueRepository
	 */
	protected $issueRepository;

	/**
	 * @var string
	 */
	protected $identifierOnRemoteSystem;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\KayStrobach\Gitlab\Domain\Model\Project\Issue>
	 * @ORM\OrderBy({"title" = "DESC"})
	 * @ORM\OneToMany(mappedBy="milestone", cascade={"all"})
	 */
	protected $issues;

	/**
	 * @var \KayStrobach\Gitlab\Domain\Model\Project
	 * @ORM\ManyToOne(inversedBy="milestones")
	 */
	protected $project;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @ORM\ManyToOne
	 * @var \KayStrobach\Gitlab\Domain\Model\Project\Milestone\State
	 */
	protected $state;

	/**
	 * @var \DateTime
	 */
	protected $created;

	/**
	 * @var \DateTime
	 */
	protected $updated;

	/**
	 * @var \DateTime
	 */
	protected $due;

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
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getIssues() {
		return $this->issues;
	}

	/**
	 * @param \Doctrine\Common\Collections\Collection $issues
	 */
	public function setIssues($issues) {
		$this->issues = $issues;
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
	 * @return Milestone\State
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * @param Milestone\State $state
	 */
	public function setState($state) {
		$this->state = $state;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreated() {
		return $this->created;
	}

	/**
	 * @param \DateTime $created
	 */
	public function setCreated($created) {
		$this->created = $created;
	}

	/**
	 * @return \DateTime
	 */
	public function getUpdated() {
		return $this->updated;
	}

	/**
	 * @param \DateTime $updated
	 */
	public function setUpdated($updated) {
		$this->updated = $updated;
	}

	/**
	 * @return \DateTime
	 */
	public function getDue() {
		return $this->due;
	}

	/**
	 * @param \DateTime $due
	 */
	public function setDue($due) {
		$this->due = $due;
	}

	/**
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function getOpenIssues() {
		return $this->issueRepository->findByMilestoneAndState($this, array('opened', 'reopened'));
	}

	/**
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function getClosedIssues() {
		return $this->issueRepository->findByMilestoneAndState($this, array('closed'));
	}

	public function getProgress() {
		$numberOfClosedIssues = $this->getClosedIssues()->count();
		$totalNumberOfIssues = $this->getIssues()->count();
		if($totalNumberOfIssues === 0) {
			return 100;
		} else {
			return ($numberOfClosedIssues / $totalNumberOfIssues) * 100;
		}
	}
}