<?php
namespace Modal;
use PDO;

class UserManager extends Manager{


//ajouter edit
	public function addUser($name,$mail,$pass){
		$cnx = $this->cnx();

		$stmt = $cnx->prepare("SELECT * FROM users WHERE name = :name OR mail = :mail");
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':mail',$mail);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Entity\User');
		$test = $stmt->fetch();
		

		if($test == false){
			$stmt = $cnx->prepare("INSERT INTO users (name, pass, mail,avatar,role,validate) VALUES (:name, :pass, :mail,'avatar/default.png',1,'no')");
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

	public function getUserById($id){
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("SELECT * FROM users WHERE id = :id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Entity\User');
		$user = $stmt->fetch();

		return $user;
	}

	public function connect($name,$pass){
		$cnx = $this->cnx();

		$stmt = $cnx->prepare("SELECT * FROM users WHERE name = :name AND pass = :pass");
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':pass',$pass);
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Entity\User');
		$stmt->execute();
		$user = $stmt->fetch();
		if($user !== false and $user->getValidate() == 'yes'){
			$_SESSION['id'] = $user->getId();
			$_SESSION['user'] = $user;
			return true;
		}
		else{
			return false;
		}
	}

	public function validate($bool,$id){
		$request = "UPDATE users SET validate = 'refused' WHERE id = :id";
		if($bool !== 'false'){
			$request = "UPDATE users SET validate = 'yes' WHERE id = :id";
		}
		$cnx = $this->cnx();
		$stmt = $cnx->prepare($request);
		$stmt->bindParam(':id',$id);
		$stmt->execute();

	}

	public function accountInvalid(){
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("SELECT * FROM users WHERE validate = 'no'");
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Entity\User');
		$stmt->execute();
		$users = $stmt->fetchAll();

		return $users;
	}

	public function userHaveRight($route,$action){
		$passed = false;
		$user = $_SESSION['user'];
		$role = $user->getRole();
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("SELECT * FROM user_right WHERE action = :action AND route = :route AND role = :role");
		$stmt->bindParam(':action',$action);
		$stmt->bindParam(':route',$route);
		$stmt->bindParam(':role',$role);
		$stmt->execute();
		$right = $stmt->fetch();
		if($right !== false){
			$passed = true;
		}
		return $passed;
	}
}