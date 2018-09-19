<?php
namespace Modal;
use PDO;
class UserManager extends Manager{

	public function addUser($name,$mail,$pass){
		$cnx = $this->cnx();

		$stmt = $cnx->prepare("SELECT pseudo FROM users WHERE pseudo = :pseudo");
		$stmt->bindParam(':pseudo', $name);
		$stmt->execute();
		$test = $stmt->fetch();
		

		if($test == false){
		$stmt = $cnx->prepare("INSERT INTO compte (pseudo, mail, pass) VALUES (:pseudo, :mail, :pass)");
		$stmt->bindParam(':pseudo', $name);
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
}