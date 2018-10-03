<?php


/*LOAD ROUTE ACTION*/
$controller->addAction('inscription',false);
$controller->addAction('connection',false);

class ControllerAccount{

	public static function defaut(){
		/*echo var_dump("oki");*/
	}

	/*return false si une érreure c'est produit*/
	public static function inscription(){
		$error = false;
		if(array_key_exists('name', $_POST)){
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
					$userManager->addUser($name,$mail,$pass);
				}
		}
		return ["error" => $error];
	}

	public static function connection(){
		/*echo var_dump("connection");*/
	}

}


