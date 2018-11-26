<?php
namespace Modal;
use PDO;
use \Entity\User;

class UserManager extends Manager{




	public function getUserById($id){
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("SELECT * FROM user WHERE id = :id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Entity\User');
		$user = $stmt->fetch();

		return $user;
	}

	public function connect($name,$pass){
		$cnx = $this->cnx();

		$stmt = $cnx->prepare("SELECT * FROM user WHERE name = :name AND pass = :pass");
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
		$request = "UPDATE user SET validate = 'refused' WHERE id = :id";
		if($bool !== 'false'){
			$request = "UPDATE user SET validate = 'yes' WHERE id = :id";
		}
		$cnx = $this->cnx();
		$stmt = $cnx->prepare($request);
		$stmt->bindParam(':id',$id);
		$stmt->execute();

	}

	public function accountInvalid(){
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("SELECT * FROM user WHERE validate = 'no'");
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

	public function userHaveMultipleRight($route,$subAction){
		$user = $_SESSION['user'];
		$role = $user->getRole();
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("SELECT * FROM user_right WHERE route = :route AND role = :role");
		$stmt->bindParam(':route',$route);
		$stmt->bindParam(':role',$role);
		$stmt->execute();
		$right = $stmt->fetchAll();
		$actionRight = [];
		/*init tab*/
		$i = 0;
		while($i < count($subAction)){
			$actionRight[$subAction[$i]] = false;
			$i++;
		}

		/*check action right*/
		$i = 0;
		while($i < count($right)){
			if(array_key_exists($right[$i]['action'], $actionRight) === true){
				$actionRight[$right[$i]['action']] = true;
			}
			$i++;
		}
		return $actionRight;
	}

	public function changePassword($pass){
		$id = $_SESSION['id'];
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("UPDATE user SET `pass` = :pass WHERE `id` = :id");
		$stmt->bindParam(':id',$id, PDO::PARAM_INT);
		$stmt->bindParam(':pass',$pass);
		$stmt->execute();
	}

	public function delete($id){
		$cnx = $this->cnx();
		$stmt = $cnx->prepare("DELETE FROM user WHERE `id` = :id");
		$stmt->bindParam(':id',$id, PDO::PARAM_INT);
		$stmt->execute();
	}
}
