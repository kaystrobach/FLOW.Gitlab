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
class MilestoneRepository extends Repository {

	/**
	 * @param Project $project
	 * @param string $remoteId
	 * @return \KayStrobach\Gitlab\Domain\Model\Project\Milestone
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
}