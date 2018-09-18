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
}