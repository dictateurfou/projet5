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
		while(count($this->app) > $i){
			var_dump(explode("/",$this->app[$i]["name"]));
			if($this->app[$i]["name"] == $this->HTTPRequest->requestURI()){
				var_dump(explode("/", $this->app[$i]["name"]));

			}
			$i++;
		}
	}


}