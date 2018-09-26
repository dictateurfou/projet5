<?php

/*LOAD ROUTE ACTION*/
$controller->addAction('viewAll',false);
$controller->addAction('view',["id"]);
$controller->addAction('addPost',false);

class ControllerPost{
 	public static function viewAll(){
		$postManager = new \Modal\PostManager();
 		return ["articles" => $postManager->viewAll()];
 	}

 	public static function view(){
 		if(array_key_exists('id', $_GET)){
 			$postManager = new \Modal\PostManager();
 			return ["article" => $postManager->view($_GET['id'])];
 		}
 		else{
 			/*créer une redirection page 404*/
 		}
 	}

 	public static function addPost(){
 		$image = new \Entity\File($_FILES['image']);
 		var_dump($image->checkValidExtension(array('jpg','jpeg','png')));
 		if(!empty($_POST['title']) && !empty($_POST['content']) && $_FILES['image']['error'] == 0 && $image->checkValidExtension(array('jpg','jpeg','png'))){
 			var_dump("passe2");
 			$name = md5(uniqid(rand(), true)).'.'.$image->checkType();
 			$target = 'post/'.$name;
 			$image->changeFolder($target);
 			$postManager = new \Modal\PostManager();
 			$postManager->addPost($_POST['title'],$target,$_POST['content']);

 		}
 	}

}

