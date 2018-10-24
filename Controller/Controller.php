<?php
namespace Controller;
/*for twig component*/
require_once("vendor/autoload.php");
class Controller{
	private $vue;
	private $controller;
	private $route;
	private $routeList = [];
	private $action = false;
	private $url;
	const EXTENSIONCLASSE = '.php';
	const EXTENSIONVIEW = '.twig';
	const DEFAULTPAGE = 'post';
	const DEFAULTACTION = 'viewAll';
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
	public function render(){
		$find = false;
		$i = 0;
		$className = "\Controller\\".$this->controller;
		$methodName = "defaut";
		$userManager = new \Modal\UserManager();
		$urlExplode = explode('/', $this->url);
		$actionOffset = 1;
		
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
					$methodName = $this->action[$i]["name"];
					$this->vue = $this->vue.$this->action[$i]["name"];
					$find = true;
					//required connect
					if($this->action[$i]["connected"] == true){
						if(!array_key_exists('id',$_SESSION)){
							$find = false;
						}
						else if($this->action[$i]["restricted"] == true && $userManager->userHaveRight($this->route,$actionExplode[0]) == false){
							$find = false;
						}
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
			$loaderTwig = new \Twig_Loader_Filesystem(__DIR__.'/../View');
			$twig = new \Twig_Environment($loaderTwig);
			$result = $className::$methodName();
			if($result != null){
				return $twig->render($this->vue.self::EXTENSIONVIEW, $result);
			}
			else{
				return $twig->render($this->vue.self::EXTENSIONVIEW, ["nothing" => ""]);
			}
		}
		
	}
	public function addRoute($name){
			array_push($this->routeList,["name" => $name]);
	}
	public function addAction($name,$connected,$restricted){
		if($this->action == false){
			$this->action = [];
			array_push($this->action,["name" => $name,"connected" => $connected,'restricted' => $restricted]);
		}
		else{
			array_push($this->action,["name" => $name,"connected" => $connected,'restricted' => $restricted]);
		}
	}
}
