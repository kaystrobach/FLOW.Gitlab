<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 27.05.15
 * Time: 17:43
 */

namespace KayStrobach\Gitlab\Utility;


use KayStrobach\Gitlab\Domain\Model\Group;
use KayStrobach\Gitlab\Domain\Model\Project;
use KayStrobach\Gitlab\Domain\Model\Server;

class FetchDataUtility {
	protected function getByUrl($url, $token) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($curl,CURLOPT_CONNECTTIMEOUT,25);
		curl_setopt ($curl,CURLOPT_TIMEOUT,25);
		curl_setopt ($curl,CURLOPT_MAXREDIRS,10);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('PRIVATE-TOKEN: ' . $token));
		$result = json_decode(curl_exec($curl), TRUE);
		curl_close($curl);
		return $result;
	}

	public function fetchGroups(Server $server) {
		return $this->getByUrl(
			$server->getUri() . '/api/v3/groups',
			$server->getToken()
		);
	}

	public function fetchProjects(Server $server) {
		return $this->getByUrl(
			$server->getUri() . '/api/v3/projects/',
			$server->getToken()
		);
	}

	public function fetchIssues(Project $project) {
		$page = 1;
		$issues = array();
		do {
			$newIssues = $this->getByUrl(
				$project->getServer()->getUri() . '/api/v3/projects/' . $project->getIdentifierOnRemoteSystem() . '/issues/?page=' . $page,
				$project->getServer()->getToken()
			);
			$page++;
			if(count($newIssues) > 0) {
				$issues = array_merge($issues, $newIssues);
			}
		} while(count($newIssues) > 0);
		return $issues;
	}

	public function fetchMilestones($project) {
		$page = 1;
		$milestones = array();
		do {
			$newMilestones = $this->getByUrl(
				$project->getServer()->getUri() . '/api/v3/projects/' . $project->getIdentifierOnRemoteSystem() . '/milestones/?page=' . $page,
				$project->getServer()->getToken()
			);
			$page++;
			if(count($newMilestones) > 0) {
				$milestones = array_merge($milestones, $newMilestones);
			}
		} while(count($newMilestones) > 0);
		return $milestones;
	}

}