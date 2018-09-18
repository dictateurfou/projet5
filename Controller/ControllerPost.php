<?php

/*LOAD ROUTE ACTION*/
$controller->addAction('viewAll',false);
$controller->addAction('post',["id"]);

class ControllerPost{
 	public static function viewAll(){
		$userManager = new \Modal\PostManager();
		$userManager->viewAll();
 		var_dump("ok");
 		var_dump($userManager->viewAll());
 	}

}

