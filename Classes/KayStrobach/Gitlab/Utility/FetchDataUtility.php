<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 27.05.15
 * Time: 17:43
 */

namespace KayStrobach\Gitlab\Utility;


use KayStrobach\Gitlab\Domain\Model\Group;
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


}