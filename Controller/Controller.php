<?php
namespace Controller;

class Controller{

	private $vue;
	private $controller;
	private $route = [];
	private $action = false;
	
	const EXTENSIONCLASSE = '.php';
	const EXTENSIONVIEW = '.phtml';
	const DEFAULTPAGE = 'account';
	const DEFAULTACTION = 'connection';

	public function control(){
		$find = false;
		$i = 0;
		while(count($this->route) > $i){
			/*cherche si ?route es spécifier en rapport avec les routes principals*/
			if(array_key_exists($this->route[$i]['name'],$_GET)){
				$this->vue = $this->route[$i]['name']."/";
				$this->controller = "Controller".ucfirst($this->route[$i]['name']);
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


	public function checkAction(){
		$find = false;
		$i = 0;
		$className = "\Controller\\".$this->controller;
		$methodName = "defaut";
		/*var_dump($this->action);*/
		if(array_key_exists('action',$_GET)){
			while($i < count($this->action)){
				if($_GET["action"] == $this->action[$i]["name"]){
					$className = $this->controller;
					$methodName = $this->action[$i]["name"];
					$this->vue = $this->vue.$this->action[$i]["name"];
					$find = true;
				}
				$i++;
			}
		}

		if($find == false){
			/*si aucune action ne correspond a la route on redirige vers la route par défaut */
			header('Location: /index.php?'.self::DEFAULTPAGE.'&action='.self::DEFAULTACTION);
		} 

		return "\Controller\\".$className::$methodName();
	}

	public function addRoute($name){
			array_push($this->route,["name" => $name]);
	}

	public function addAction($name,$arg){
		if($this->action == false){
			$this->action = [];
			array_push($this->action,["name" => $name,"arg" => $arg]);
		}
		else{
			array_push($this->action,["name" => $name,"arg" => $arg]);
		}
	}
}



