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

    public function getProperties(){
        return get_object_vars($this);
    }

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
		return $this->avatar;
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
		$this->avatar = $arg;
	}

	public function setRole($arg){
		$this->role = $arg;
	}

	public function setValidate($arg){
		$this->validate = $arg;
	}

}
