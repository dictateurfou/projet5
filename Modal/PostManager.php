<?php

namespace Modal;
use PDO;

class PostManager extends Manager{

	public function viewAll(){
		$utils = new \Entity\Utils();
		$post = $utils->getObjectInObject("post",["author"=>'user']);
		return $post;		
	}

	public function view($id){
		$utils = new \Entity\Utils();
		$post = $utils->getObjectInObject("post",["author"=>'user'],"WHERE post.id = :id",[":id" => $id]);
		if($post !== false){
			$post = $post[0];
		}

		return $post;

	}


}
