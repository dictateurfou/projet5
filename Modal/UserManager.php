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
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Entity\User');
		$test = $stmt->fetch();
		

		if($test == false){
			$stmt = $cnx->prepare("INSERT INTO users (name, pass, mail,avatar,role) VALUES (:name, :pass, :mail,'avatar/default.png',1)");
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':mail', $mail);
			$stmt->bindParam(':pass', $pass);
			$stmt->execute();

			$message = "bravo l'inscription c'est bien dérouler vous pouvez a present vous connecter";
		}

		else{
			if($test->getName() == $name){
				$message = "ce nom dutilisateur es déja pris veuillez en choisir un autre";
			}
			else{
				$message = "ce mail es déja enrengistrer";
			}
			
		}
		return $message;
	}

	public function connect($name,$pass){
		$cnx = $this->cnx();

		$stmt = $cnx->prepare("SELECT * FROM users WHERE name = :name AND pass = :pass");
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':pass',$pass);
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Entity\User');
		$stmt->execute();
		$user = $stmt->fetch();
		if($user !== false){
			$_SESSION['id'] = $user->getId();
			return true;
		}
		else{
			return false;
		}
	}

	public function validate($bool,$id){
		$request = "UPDATE users SET role = 0 WHERE id = :id";
		if($bool){
			$request = "UPDATE users SET role = 2 WHERE id = :id";
		}
		$cnx = $this->cnx();
		$stmt = $cnx->prepare($request);
		$stmt->bindParam(':id',$id);
		$stmt->execute();

	}

	public function accountInvalid(){
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("SELECT * FROM users WHERE role = 1");
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Entity\User');
		$stmt->execute();
		$users = $stmt->fetchAll();

		return $users;
	}
}