<?php

namespace KayStrobach\Gitlab\Domain\Model\Project\Issue;

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\ValueObject
 */
class State {
	/**
	 * @var string
	 */
	protected $title = '';

	/**
	 * @param $title
	 */
	public function __construct($title) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}
}