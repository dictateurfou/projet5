<?php

/*LOAD ROUTE ACTION*/
$controller->addAction('viewAll',false);
$controller->addAction('view',["id"]);

class ControllerPost{
 	public static function viewAll(){
		$userManager = new \Modal\PostManager();
 		return ["articles" => $userManager->viewAll()];
 	}

 	public static function view(){
 		if(array_key_exists('id', $_GET)){
 			$userManager = new \Modal\PostManager();
 			return ["article" => $userManager->view($_GET['id'])];
 		}
 		else{
 			/*créer une redirection page 404*/
 		}
 	}

}

