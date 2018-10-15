<?php

namespace Entity;

class User
{
	private $id;
	private $name;
	private $pass;
	private $mail;
	private $avatar;
	private $role;

	public function getId(){
		return $this->id;
	}

	public function getName(){
		return $this->name;
	}

	public function getPass(){
		return $this->pass;
	}

	public function getMail(){
		return $this->mail;
	}

	public function getAvatar(){
		return $this->image;
	}

	public function getRole(){
		return $this->role;
	}


	public function setId($arg){
		$this->id = $arg;
	}

	public function setName($arg){
		$this->name = $arg;
	}

	public function Pass($arg){
		$this->pass = $arg;
	}

	public function getMail($arg){
		$this->mail = $arg;
	}

	public function getAvatar($arg){
		$this->image = $arg;
	}

	public function getRole($arg){
		$this->role = $arg;
	}

}