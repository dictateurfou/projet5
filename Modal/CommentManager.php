<?php
namespace Modal;
use PDO;

class CommentManager extends Manager{



	public function getComment($post){
		$utils = new \Entity\Utils();
		return $utils->getObjectInObject("comment",["author"=>'user'],'WHERE comment.post = :post',[":post" => $post]);
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