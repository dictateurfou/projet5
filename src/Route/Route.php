<?php

namespace Route;

class Route
{
	private $route = [];
	private $HTTPRequest;
	 public function __construct(){
		$this->HTTPRequest = new \Route\HTTPRequest;
		/*$this->httpResponse = new HTTPResponse($this);*/
		var_dump($this->HTTPRequest->requestURI());
	}

	public function addRoute($name){
		array_push($this->route,["name" => $name]);
	}
}