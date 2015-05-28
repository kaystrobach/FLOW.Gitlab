<?php
namespace KayStrobach\Gitlab\Domain\Repository\Project;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "KayStrobach.Gitlab".    *
 *                                                                        *
 *                                                                        */

use KayStrobach\Gitlab\Domain\Model\Project;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class IssueRepository extends Repository {

	/**
	 * @param Project $project
	 * @param string $remoteId
	 * @return \KayStrobach\Gitlab\Domain\Model\Project\Issue
	 */
	public function findOneByProjectAndRemoteIdentifier(Project $project, $remoteId) {
		$query = $this->createQuery();
		$query->matching(
			$query->logicalAnd(
				array(
					$query->equals('project', $project),
					$query->equals('identifierOnRemoteSystem', $remoteId),
				)
			)
		);
		return $query->execute()->getFirst();
	}

	/**
	 * @param Project\Milestone $milestone
	 * @param string $state
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function findByMilestoneAndState(Project\Milestone $milestone, $state) {
		$query = $this->createQuery();
		$query->matching(
			$query->logicalAnd(
				array(
					$query->equals('milestone', $milestone),
					$query->in('state.title', $state),
				)
			)
		);
		return $query->execute();
	}
}