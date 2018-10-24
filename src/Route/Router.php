<?php

namespace Route;

class Router
{
	private $route = [];
	private $app = [];
	private $HTTPRequest;
	public function __construct(){
		$this->HTTPRequest = new \Route\HTTPRequest;
	}

	public function addApp($name,$url){
		array_push($this->app,["name" => $name,"$url" => $url]);
	}

	public function addRoute($name){
		array_push($this->route,["name" => $name]);
	}

	public function getHTTPRequest(){
		return $this->HTTPRequest;
	}

	public function checkApp(){
		$i = 0;
		$uriFindNb = 0;
		$uriFind = false;
		while(count($this->app) > $i){
			$uri = explode("/",$this->HTTPRequest->requestURI());
			$app = explode("/",$this->app[$i]["name"]);
			if($app === $uri){
				var_dump("default route break boucle and send result (a faire)");
				$uriFind = false;
				break;
			}
			else{
 				if(strpos($this->HTTPRequest->requestURI(),$this->app[$i]["name"]) !== false){
 					if($uriFindNb < count($app)){
 						var_dump("true");
 					}
				    
				}
			}
			$i++;
		}
	}


}