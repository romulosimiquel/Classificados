<?php
class Core {

	public function run() {

		$url = '/';
		$camim = explode('/', $_SERVER['REQUEST_URI']);
		array_shift($camim);
		array_shift($camim);
		array_shift($camim);

		if(!empty($_GET['url'])) {
			$url .= $camim;
		}

		echo "<h1>".print_r($camim)."</h1>";

		$params = array();

		if(!empty($url) && $url != '/') {
			$url = explode('/', $url);
			array_shift($url);

			$currentController = $url[0].'Controller';
			array_shift($url);

			if(isset($url[0]) && !empty($url[0])) {
				$currentAction = $url[0];
				array_shift($url);
			} else {
				$currentAction = 'index';
			}

			if(count($url)>0); {
				$params = $url;
			}

		} else {
			$currentController = 'homeController';
			$currentAction = 'index';
		}

		$control = new $currentController();

		call_user_func_array(array($control, $currentAction), $params);

	}

}