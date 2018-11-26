<?php


/*LOAD ROUTE ACTION*/
$controller->addAction('inscription',false,false);
$controller->addAction('connection',false,false);
$controller->addAction('validation/state/id', true,true);
$controller->addAction('editProfile/subAction',true,false);
$controller->addAction('disconnect',false,false);



class ControllerAccount{

	public static function defaut(){
		/*echo var_dump("oki");*/
	}

	/*return false si une érreure c'est produit*/
	public static function inscription(){
		$error = false;
		if(array_key_exists('name', $_POST) === true){
			/*htmlspecialchars(*/
				$name = htmlspecialchars($_POST['name']);
				$mail = htmlspecialchars($_POST['mail']);
				$pass = $_POST['pass'];

				$error = [];
				if(strlen($name > 20)){
					array_push($error, "le pseudo ne doit pas depasser les 20 caractere");

				}

				if(strlen($mail) >= 255){
					array_push($error, "le mail ne doit pas depasser les 255 caractere");
				}

				if(strlen($mail) == 0){
					array_push($error, "vous n'avez pas rempli le champ mail");
				}

				if(strlen($name) < 5){
					array_push($error, "votre pseudo doit faire 5 caractére minimum");
				}

				if(strlen($pass) < 8){
					array_push($error, " votre mot de passe doit faire 8 caractére minimum");
				}

				if(strlen($pass) > 30){
					array_push($error, "votre mot de passe ne doit pas depasser 30 caractére il faut s'en souvenir apres");
				}

				if(count($error) == 0){
					$userManager = new Modal\UserManager();
					$pass = hash('sha256', $_POST['pass']);
					return ["error" => [$userManager->addUser($name,$mail,$pass)]];
				}
				else{
					return ["error" => $error];
				}
		}
		
	}

	

	public static function connection(){
		/*echo var_dump("connection");*/
		if(empty($_POST['pass']) === false && empty($_POST['name']) === false){
			$pass = hash('sha256', $_POST['pass']);
			$name = $_POST['name'];
			$userManager = new Modal\UserManager();
			$verif = $userManager->connect($name,$pass);
			if($verif){
				header('Location: /');
			}
			else{
				return ["connect" => "l'identifiant ou le mot de passe n'est pas correct"];
			}
		}
	}

	public static function validation(){
		$userManager = new Modal\UserManager();
		if(!empty($_GET['id']) && !empty($_GET['state'])){
			$id = $_GET["id"];
			$state = $_GET["state"];
			$userManager->validate($state,$id);
		}
		return ["validation" => $userManager->accountInvalid()];
	}

	public static function PasswordMissing($mail){

	}


	public function disconnect(){
		session_destroy();
		header('location:/');
	}

	public static function editProfile(){
		$userManager = new Modal\UserManager();
		if(!empty($_GET['subAction'])){
			$action = $_GET['subAction'];
			if($action == "delete"){
				$userManager->delete($_SESSION['id']);
				session_destroy();
				header('Location: /index.php');
			}
			elseif($action == "changePassword"){
				if(!empty($_POST['password'])){
					$pass = hash('sha256', $_POST['password']);
					$userManager->changePassword($pass);
					session_destroy();
					header('Location: /index.php');
				}
			}
		}
	}


}



