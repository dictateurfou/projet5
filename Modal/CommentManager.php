<?php
namespace Modal;
use PDO;

class CommentManager extends Manager{



	public function getComment($id){
		$utils = new \Entity\Utils();
		$test = $utils->getObjectInObject("comment",["author"=>'user']);
		return $utils->getObjectInObject("comment",["author"=>'user']);
	}

	public function addComment($post,$user,$content){
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("INSERT INTO `comment`(`author`, `post`, `content`, `date`, `valid`) VALUES (:author,:post,:content,NOW(),0)");
		$stmt->bindParam(':author',$user);
		$stmt->bindParam(':post',$post);
		$stmt->bindParam(':content',$content);
		$stmt->execute();
	}

}