<?php

/*LOAD ROUTE ACTION*/
$controller->addAction('viewAll',false);
$controller->addAction('post',["id"]);

class ControllerPost{
 	public static function viewAll(){
		$userManager = new \Modal\PostManager();
		$userManager->viewAll();
 		return $userManager->viewAll();
 	}

 	public function post($id){
 		$userManager = new \Modal\PostManager();
 	}

}

