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
class Tag {

	/**
	 * @var string
	 */
	protected $identifierOnRemoteSystem;

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


}