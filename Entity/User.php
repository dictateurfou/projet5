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
	private $validate;

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

	public function getValidate(){
		return $this->validate;
	}

	public function setId($arg){
		$this->id = $arg;
	}

	public function setName($arg){
		$this->name = $arg;
	}

	public function setPass($arg){
		$this->pass = $arg;
	}

	public function setMail($arg){
		$this->mail = $arg;
	}

	public function setAvatar($arg){
		$this->image = $arg;
	}

	public function setRole($arg){
		$this->role = $arg;
	}

	public function setValidate($arg){
		$this->validate = $arg;
	}

}
