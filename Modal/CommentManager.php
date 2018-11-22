<?php
namespace Modal;
use PDO;

class CommentManager extends Manager{



	public function getComment($id){
		$utils = new \Entity\Utils();
		return $utils->getObjectInObject("comment",["author"=>'user'],"WHERE comment.post = :post AND valid = 'yes'",[":post" => $id]);
	}

	public function addComment($post,$user,$content){
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("INSERT INTO `comment`(`author`, `post`, `content`, `date`, `valid`) VALUES (:author,:post,:content,NOW(),'no')");
		$stmt->bindParam(':author',$user);
		$stmt->bindParam(':post',$post);
		$stmt->bindParam(':content',$content);
		$stmt->execute();
	}

	public function getInvalidComment(){
		$cnx = $this->cnx();
		$utils = new \Entity\Utils();
		return $utils->getObjectInObject("comment",["author"=>'user',"post" => 'post'],"WHERE valid = 'no'");
	}

	public function validate($bool,$id){
		$request = "UPDATE comment SET valid = 'refused' WHERE id = :id";
		if($bool !== 'false'){
			$request = "UPDATE comment SET valid = 'yes' WHERE id = :id";
		}
		$cnx = $this->cnx();
		$stmt = $cnx->prepare($request);
		$stmt->bindParam(':id',$id);
		$stmt->execute();
	}

}