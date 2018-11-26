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

	public function addPost($title,$image,$content){
		$author = $_SESSION['user']->getId();
		$cnx = $this->cnx();
		$date = date('Y-m-d h:m:s');
		$stmt = $cnx->prepare("INSERT INTO `post`(`title`, `image`, `content`, `author`, `createdAt`, `editedAt`) VALUES (:title,:image,:content,:author,NOW(),NOW())");

		$stmt->bindParam(':title',$title);
		$stmt->bindParam(':image',$image);
		$stmt->bindParam(':content',$content);
		$stmt->bindParam(':author',$author);
		$stmt->execute();
	}

	public function edit($title,$content,$id,$image = null){
		$cnx = $this->cnx();
		
		if($image !== null){
			$stmt = $cnx->prepare("UPDATE post SET `title` = :title,`content` = :content, `image` = :image,`editedAt` = NOW() WHERE `id` = :id");
			$stmt->bindParam(':image',$image);
		}
		else{
			$stmt = $cnx->prepare("UPDATE post SET `title` = :title,`content` = :content,`editedAt` = NOW() WHERE `id` = :id");
		}

		$stmt->bindParam(':title',$title);
		$stmt->bindParam(':content',$content);
		$stmt->bindParam(':id',$id);
		$stmt->execute();

	}

	public function delete($id){
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("DELETE FROM `post` WHERE id = :id");
		$stmt->bindParam(':id',$id);
		$stmt->execute();
	}
}
