<?php

/*LOAD ROUTE ACTION*/

$controller->addAction('viewAll',false,false);
$controller->addAction("view/id",false,false);
$controller->addAction('addPost',true,true);
$controller->addAction('edit/id',true,true);
$controller->addAction('delete/id',true,true);

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
 		if(array_key_exists('image', $_FILES)){
 			$image = new \Entity\File($_FILES['image']);

	 		if(!empty($_POST['title']) && !empty($_POST['content']) && $_FILES['image']['error'] == 0 && $image->checkValidExtension(array('jpg','jpeg','png'))){
	 			$name = md5(uniqid(rand(), true)).'.'.$image->checkType();
	 			$target = 'post/'.$name;
	 			$image->changeFolder($target);
	 			$postManager = new \Modal\PostManager();
	 			/* mettre post en objet */
	 			$postManager->addPost($_POST['title'],$target,$_POST['content']);

	 		}
	 	}
 	}

 	public static function edit(){
 		$postManager = new \Modal\PostManager();

 		if(!empty($_POST['title']) && !empty($_POST['content']) && $_FILES['image']['error'] == 4 && !empty($_GET['id'])){
 			$postManager->edit($_POST['title'],$_POST['content'],$_GET['id']);
 		}
 		/*si post avec image*/
 		elseif(!empty($_POST['title']) && !empty($_POST['content']) && $_FILES['image']['error'] == 0 && !empty($_GET['id'])){
 			$image = new \Entity\File($_FILES['image']);
 			if($image->checkValidExtension(array('jpg','jpeg','png'))){
	 			$name = md5(uniqid(rand(), true)).'.'.$image->checkType();
	 			$target = 'post/'.$name;
	 			$image->changeFolder($target);
	 			$postManager->edit($_POST['title'],$_POST['content'],$_GET['id'],$target);
	 			/*ajouter redirection*/
	 			header('Location: /index.php?post&action=view&id='.$_GET['id']);
	 		}
 		}
 		else{
 			if(!empty($_GET['id'])){
 				$article = $postManager->view($_GET['id']);
 				if($article !== false){
 					return ["article" => $article];
 				}
 				else{
 					/* redirect post inconnu */

 				}
 			}
 			else{
 				/* redirect */
 			}
 		}
 	}

 	public static function delete(){
 		if(array_key_exists('id', $_GET)){
 			$postManager = new \Modal\PostManager();
 			$postManager->delete($_GET['id']);
 			header('Location: /index.php?post&action=viewAll');
 		}
 	}

}
