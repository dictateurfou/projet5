<?php
namespace Modal;
use PDO;

class UserManager extends Manager{

	public function addUser($name,$mail,$pass){
		$cnx = $this->cnx();

		$stmt = $cnx->prepare("SELECT * FROM users WHERE name = :name OR mail = :mail");
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':mail',$mail);
		$stmt->execute();
		$test = $stmt->fetch();
		
		var_dump($test);
		if($test == false){
			$stmt = $cnx->prepare("INSERT INTO users (name, pass, mail,avatar,role) VALUES (:name, :pass, :mail,'avatar/default.png',0)");
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':mail', $mail);
			$stmt->bindParam(':pass', $pass);
			$stmt->execute();

			$message = "<div class='succes'>bravo l'inscription c'est bien dérouler vous pouvez a present vous connecter</div>";
		}

		else{
			$message = "<div class='erreur'>ce nom dutilisateur es déja pris veuillez en choisir un autre</div>";
		}
		return $message;
	}

	public function connect(){

	}
}