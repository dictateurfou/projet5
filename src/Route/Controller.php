<?php
namespace Route;

class Controller{

	private $vue;
	private $controller;
	private $route = [];
	private $action = false;
	/* pour les feneant ^^ */
	const EXTENSIONCLASSE = '.class.php';
	const EXTENSIONVIEW = '.phtml';
	const DEFAULTPAGE = 'default';

	public function control(){
		$i = 0;
		while(count($this->route) > $i){
			if(array_key_exists($this->route[$i]['name'],$_GET)){
				$this->vue = $this->route[$i]['name']."/";
				$this->controller = "Controller".ucfirst($this->route[$i]['name']);
			}
			$i++;
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
		$className = $this->controller;
		$methodName = "defaut";
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
			$this->vue = self::DEFAULTPAGE;
		} 
		return $className::$methodName();
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