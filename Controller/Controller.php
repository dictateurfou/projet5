<?php
namespace Controller;
/*for twig component*/
require_once("vendor/autoload.php");
use \Twig_Loader_Filesystem;
class Controller{
	private $vue;
	private $controller;
	private $route;
	private $routeList = [];
	private $action = false;
	private $url;
	private $header = [];
	const EXTENSIONCLASSE = '.php';
	const EXTENSIONVIEW = '.twig';
	const DEFAULTPAGE = 'post';
	const DEFAULTACTION = 'viewAll';
	const DEFAULTBANNER = "/assets/img/home-bg.jpg";
	const DEFAULT_TITLE = "Mon Blog";
	const DEFAULTSUBTITLE = "Un blog parlant de développement";
	const DEFAULTHEADER = "header/default.twig";
	public function __construct(){
		$this->url = ltrim($_SERVER['REQUEST_URI'],'/');
	}
	public function control(){
		$find = false;
		$i = 0;
		$namespace = explode('/', $this->url)[0];
		while(count($this->routeList) > $i){
			/*cherche si ?routeList es spécifier en rapport avec les routeLists principals*/
			if($this->routeList[$i]['name'] == $namespace){
				$this->route = $this->routeList[$i]['name'];
				$this->vue = $this->routeList[$i]['name']."/";
				$this->controller = "Controller".ucfirst($this->routeList[$i]['name']);
				$find = true;
			}
			$i++;
		}
		/*si aucune route trouver on redirige vers la route par defaut */
		if($find == false){
			header('Location: /'.self::DEFAULTPAGE.'/'.self::DEFAULTACTION);
		}
		/*$this->checkAction();*/
	}
	public function getvue(){
		return $this->vue.self::EXTENSIONVIEW;
	}
	public function getController(){
		return $this->controller.self::EXTENSIONCLASSE;
	}

	public function setHeader($header){
		$this->header = $header;
	}

	public function getHeader(){
		return $this->header;
	}


	public function render(){
		$find = false;
		$i = 0;
		$className = "\Controller\\".$this->controller;
		$methodName = "defaut";
		$userManager = new \Modal\UserManager();
		$urlExplode = explode('/', $this->url);
		$actionOffset = 1;
		$subAction = false;
		$defautAction = false;
		$actionIndex;

		if(array_key_exists($actionOffset,$urlExplode) === false){
			$urlExplode[1] = "";
			$defautAction = true;
			if($urlExplode[0] !== "adminPanel"){
				$this->vue = $urlExplode[0]."/defaut";
			}
			else{
				$this->vue = "/defaut";
			}
		}
		/*si connecter on met le résultat de l'user en session pour un usage global*/
		if(array_key_exists('id',$_SESSION)){
			$_SESSION['user'] = $userManager->getUserById($_SESSION['id']);
		}
		if(array_key_exists($actionOffset,$urlExplode)){
			while($i < count($this->action)){

				$actionExplode = explode('/', $this->action[$i]["name"]);
				/*si l'action contient des paramètre on lui attribut au tableau get et sont défini dans l'url actuelle*/
				if(isset($urlExplode[2]) && strpos($this->action[$i]["name"], "/") !== false){
					$this->action[$i]["name"] = $actionExplode[0];
					$e = 1;
					while($e < count($actionExplode)){
						$_GET[$actionExplode[$e]] = $urlExplode[$e+1];
						$e++;
					}
				}
				/*sinon si l'argument n'est pas défini dans l'url et que la route correspond (pour les url avec paramètre optionel) */
				else if(!isset($urlExplode[2]) && strpos($this->action[$i]["name"], "/") !== false){
					$this->action[$i]["name"] = $actionExplode[0];
				}
				/* ici on check si l'action correspond a l'url */
				if($urlExplode[$actionOffset] == $this->action[$i]["name"]){
					$className = $this->controller;
					/*si on es sur l'action par défaut*/
					if($defautAction == false){
						$methodName = $this->action[$i]["name"];
						$this->vue = $this->vue.$this->action[$i]["name"];
						$actionIndex = $i;
					}
					else{
						$this->vue = $this->vue.$this->action[$i]["name"];
						$actionIndex = $i;
					}
					$find = true;
					//required connect
					if($this->action[$i]["connected"] == true){
						if(!array_key_exists('id',$_SESSION)){
							$find = false;
						}
						else if($this->action[$i]["restricted"] === true && $userManager->userHaveRight($this->route,$actionExplode[0]) === false){
							$find = false;
						}
						/*check les droit des action secondaire pour savoir si on affiche les boutton dans twig*/
					}

					/*check les droit des action secondaire pour savoir si on affiche les boutton dans twig*/
					if(array_key_exists('restrictedSubAction', $this->action[$i]) && $find !== false && array_key_exists('id',$_SESSION) === true){
						$userSubActionRight = $userManager->userHaveMultipleRight($this->route,$this->action[$i]['restrictedSubAction']);
						$subAction = true;
					}

				}
				$i++;
			}
		}
		/*si page n'existe pas on redirige*/
		if($find == false){
			/*si aucune action ne correspond a la routeList on redirige vers la route par défaut */
			header('Location: /'.self::DEFAULTPAGE.'/'.self::DEFAULTACTION);
		}
		/*sinon (condition obliger sinon éxecute quand même l'action avant redirection)*/
		else{
			/*si on doit rajouter une aplication rajouter une condition*/
			if($urlExplode[0] == "adminPanel"){
				if($this->vue !== "/defaut"){
					$this->vue = $this->action[$actionIndex]["name"];
				}
				$loaderTwig = new \Twig_Loader_Filesystem('./View/adminPanel');
			}
			else{
				$loaderTwig = new \Twig_Loader_Filesystem('./View');
			}
			$twig = new \Twig_Environment($loaderTwig);
			$result = $className::$methodName();
			if($result !== null){
				if($subAction === true){
					$result["right"] = $userSubActionRight;
				}
				if(array_key_exists('header', $result) === false){
					$result["header"] = ["view" => self::DEFAULTHEADER,"title" => self::DEFAULT_TITLE,"subtitle" => self::DEFAULTSUBTITLE,"img" => self::DEFAULTBANNER];
				}
				/*verifier array key header (retour de className::methodName)*/
				return $twig->render($result["header"]["view"], $result["header"]).$twig->render($this->vue.self::EXTENSIONVIEW, $result);
			}
			else{
				$header = ["view" => self::DEFAULTHEADER,"title" => self::DEFAULT_TITLE,"subtitle" => self::DEFAULTSUBTITLE,"img" => self::DEFAULTBANNER];
				return $twig->render($header["view"], $header).$twig->render($this->vue.self::EXTENSIONVIEW, ["nothing" => ""]);
			}
		}
	}

	public function addRoute($name){
		array_push($this->routeList,["name" => $name]);
	}
	public function addAction($name,$connected,$restricted,$restrictedSubAction = null){
		if($this->action == false){
			$this->action = [];
		}

		if($restrictedSubAction !== null){
			array_push($this->action,["name" => $name,"connected" => $connected,'restricted' => $restricted,'restrictedSubAction' => $restrictedSubAction]);
		}
		else{
			array_push($this->action,["name" => $name,"connected" => $connected,'restricted' => $restricted]);
		}
	}
}
