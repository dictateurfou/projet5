<?php
/*LOAD ROUTE ACTION*/
$controller->addAction('inscription',false);
$controller->addAction('connection',false);

class ControllerAccount{

	public static function defaut(){
		echo var_dump("oki");
	}

	/*return false si une érreure c'est produit*/
	public static function inscription(){
		$error = false;
		if(array_key_exists('pseudo', $_POST)){
			/*htmlspecialchars(*/
				$pseudo = htmlspecialchars($_POST['pseudo']);
				$mail = htmlspecialchars($_POST['mail']);
				$pass = $_POST['pass'];

				$error = [];
				if(strlen($pseudo > 20)){
					array_push($error, "<div class='erreur'>le pseudo ne doit pas depasser les 20 caractere</div>");

				}

				if(strlen($mail) >= 255){
					array_push($error, "<div class='erreur'>le mail ne doit pas depasser les 255 caractere</div>");
				}

				if(strlen($mail) == 0){
					array_push($error, "<div class='erreur'>vous n'avez pas rempli le champ mail</div>");
				}

				if(strlen($pseudo) < 5){
					array_push($error, "<div class='erreur'>votre pseudo doit faire 5 caractére minimum</div>");
				}

				if(strlen($pass) < 8){
					array_push($error, "<div class='erreur'> votre mot de passe doit faire 8 caractére minimum</div>");
				}

				if(strlen($pass) > 30){
					array_push($error, "<div class='erreur'>votre mot de passe ne doit pas depasser 30 caractére il faut s'en souvenir apres</div>");
				}

				if(count($error) == 0){
					$userManager = new UserManager();
					$pass = hash('sha256', $_POST['pass']);
					$userManager->addUser($pseudo,$mail,$pass);
				}
		}
		return $error;
	}

	public static function connection(){
		echo var_dump("connection");
	}

}


