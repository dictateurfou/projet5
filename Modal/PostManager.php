<?php

namespace Modal;

use Entity\Manager;
use PDO;

class PostManager extends Manager{

	public function viewAll(){
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("SELECT * FROM post");
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Entity\Post');
		$post = $stmt->fetchAll();
		return $post;
				
	}

	public function view($id){
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("SELECT * FROM post WHERE id = :id");
		$stmt->bindParam(':id',$id, PDO::PARAM_INT);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Entity\Post');
		$post = $stmt->fetch();
		return $post;
	}

	public function addPost($title,$image,$content){
		$cnx = $this->cnx();
		$date = date('Y-m-d h:m:s');
		$stmt = $cnx->prepare("INSERT INTO `post`(`title`, `image`, `content`, `author`, `createdAt`, `editedAt`) VALUES (:title,:image,:content,'test',:date,:date)");

		$stmt->bindParam(':title',$title, PDO::PARAM_STR);
		$stmt->bindParam(':image',$image, PDO::PARAM_STR);
		$stmt->bindParam(':content',$content, PDO::PARAM_STR);
		$stmt->bindParam(':date',$date);
		$stmt->execute();
	}

	public function edit($title,$content,$id,$image = null){
		$cnx = $this->cnx();
		$date = date('Y-m-d h:m:s');
		if($image !== null){
			$stmt = $cnx->prepare("UPDATE post SET `title` = :title,`content` = :content, `image` = :image,`editedAt` = :date WHERE `id` = :id");
			$stmt->bindParam(':title',$title, PDO::PARAM_STR);
			$stmt->bindParam(':content',$content, PDO::PARAM_STR);
			$stmt->bindParam(':image',$image, PDO::PARAM_STR);
			$stmt->bindParam(':date',$date);
			$stmt->bindParam(':id',$id);
			$stmt->execute();
		}
		else{
			$stmt = $cnx->prepare("UPDATE post SET `title` = :title,`content` = :content,`editedAt` = :date WHERE `id` = :id");
			$stmt->bindParam(':title',$title, PDO::PARAM_STR);
			$stmt->bindParam(':content',$content, PDO::PARAM_STR);
			$stmt->bindParam(':date',$date);
			$stmt->bindParam(':id',$id);
			$stmt->execute();
		}
	}

	public function delete($id){
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("DELETE FROM `post` WHERE id = :id");
		$stmt->bindParam(':id',$id, PDO::PARAM_INT);
		$stmt->execute();
	}
}