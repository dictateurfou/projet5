<?php

/*LOAD ROUTE ACTION*/
$controller->addAction('viewAll',false);
$controller->addAction('view',["id"]);
$controller->addAction('addPost',false);

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

 	public static function addPost(){
 		var_dump($_POST);
 		var_dump($_FILES['image']);
 		$image = new \Entity\File($_FILES['image']);
 		if(!empty($_POST['title']) && !empty($_POST['content']) && $_FILES['image']['error'] == 0){
 			$_FILES['image']['name'];
 			var_dump("aucune erreure");
 		}
 	}

}

