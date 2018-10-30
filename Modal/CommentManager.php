<?php
namespace Modal;
use PDO;

class CommentManager extends Manager{



	public function getComment($id){
		$utils = new \Entity\Utils();
		$test = $utils->getObjectInObject("comment",["author"=>'user']);
		return $utils->getObjectInObject("comment",["author"=>'user']);
	}

	public function addComment($post,$user){
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("INSERT INTO `comment`(`author`, `post`, `content`, `date`, `valid`) VALUES (:author,:post,:content,'NOW()',false");
		$stmt->bindParam(':author',$user, PDO::PARAM_INT);
		$stmt->bindParam(':post',$post, PDO::PARAM_INT);
		$stmt->bindParam(':content',$content, PDO::PARAM_STR);
		$stmt->execute();
	}

}