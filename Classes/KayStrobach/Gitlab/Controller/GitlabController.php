<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 13.12.14
 * Time: 09:22
 */

namespace KayStrobach\Gitlab\Controller;

use KayStrobach\Gitlab\Domain\Model\Project;
use KayStrobach\Gitlab\Domain\Model\Server;
use TYPO3\Flow\Annotations as Flow;

class GitlabController extends \TYPO3\Flow\Mvc\Controller\ActionController {
	/**
	 * @Flow\Inject
	 * @var \KayStrobach\Gitlab\Domain\Repository\ServerRepository
	 */
	protected $serverRepository;

	/**
	 *
	 */
	public function indexAction() {
		$servers = $this->serverRepository->findAll();
		if($servers->count() === 1) {
			$this->redirect(
				'projects',
				NULL,
				NULL,
				array(
					'server' => $servers->getFirst()
				)
			);
		} else {
			$this->view->assign('servers', $servers);
		}
	}

	/**
	 * @param Server $server
	 */
	public function projectsAction(Server $server) {
		if($server->getProjects()->count() === 1) {
			$this->redirect(
				'project',
				NULL,
				NULL,
				array(
					'project' => $server->getProjects()->get(0)
				)
			);
		} else {
			$this->view->assign('server', $server);
		}
	}

	public function projectAction(Project $project, $state = 'open') {
		$this->view->assign('project', $project);
	}

	/**
	 * @param Project $project
	 */
	public function milestonesAction(Project $project) {
		$this->view->assign('projec', $project);
	}

	public function milestoneAction(Project\Milestone $milestone) {
		$this->view->assign('milestone', $milestone);
	}
}