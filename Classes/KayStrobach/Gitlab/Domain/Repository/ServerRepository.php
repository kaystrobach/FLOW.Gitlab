<?php
namespace KayStrobach\Gitlab\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "KayStrobach.Gitlab".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class ServerRepository extends Repository {

	/**
	 * search by the serverIdentifier from the configuration file
	 *
	 * @param $serverIdentifier
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function findByServerIdentifier($serverIdentifier) {
		$query = $this->createQuery();
		$query->matching(
			$query->equals('serverIdentifier', $serverIdentifier)
		);
		return $query->execute();
	}
}