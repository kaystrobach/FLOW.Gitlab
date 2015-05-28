<?php
namespace KayStrobach\Gitlab\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "KayStrobach.Gitlab".    *
 *                                                                        *
 *                                                                        */

use KayStrobach\Gitlab\Domain\Model\Server;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class ProjectRepository extends Repository {

	// add customized methods here

	/**
	 * @param Server $server
	 * @param string $remoteId
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function findByServerAndRemoteIdentifier(Server $server, $remoteId) {
		$query = $this->createQuery();
		$query->matching(
			$query->logicalAnd(
				array(
					$query->equals('server', $server),
					$query->equals('identifierOnRemoteSystem', $remoteId),
				)
			)
		);
		return $query->execute();
	}
}