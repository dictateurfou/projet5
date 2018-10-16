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
	
	const EXTENSIONCLASSE = '.php';
	const EXTENSIONVIEW = '.twig';
	const DEFAULTPAGE = 'post';
	const DEFAULTACTION = 'viewAll';

	public function control(){
		$find = false;
		$i = 0;
		while(count($this->routeList) > $i){
			/*cherche si ?routeList es spécifier en rapport avec les routeLists principals*/
			if(array_key_exists($this->routeList[$i]['name'],$_GET)){
				$this->route = $this->routeList[$i]['name'];
				$this->vue = $this->routeList[$i]['name']."/";
				$this->controller = "Controller".ucfirst($this->routeList[$i]['name']);
				$find = true;
			}
			$i++;
		}

		/*si aucune route trouver on redirige vers la route par defaut */
		if($find == false){
			header('Location: /index.php?'.self::DEFAULTPAGE.'&action='.self::DEFAULTACTION);
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

		/*si connecter on met le résultat de l'user en session pour un usage global*/
		if(array_key_exists('id',$_SESSION)){
			$_SESSION['user'] = $userManager->getUserById($_SESSION['id']);
		}
		/*var_dump($this->action);*/
		if(array_key_exists('action',$_GET)){
			while($i < count($this->action)){
				if($_GET["action"] == $this->action[$i]["name"]){
					$className = $this->controller;
					$methodName = $this->action[$i]["name"];
					$this->vue = $this->vue.$this->action[$i]["name"];
					$find = true;
					//required connect
					if($this->action[$i]["connected"] == true){
						if(!array_key_exists('id',$_SESSION)){
							$find = false;
						}
						else if($this->action[$i]["restricted"] == true && $userManager->userHaveRight($this->route,$this->action[$i]["name"]) == false){
							$find = false;
						}

					}
				}
				$i++;
			}
		}

		/*si trouver on redirige*/
		if($find == false){
			/*si aucune action ne correspond a la routeList on redirige vers la routeList par défaut */
			header('Location: /index.php?'.self::DEFAULTPAGE.'&action='.self::DEFAULTACTION);
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



