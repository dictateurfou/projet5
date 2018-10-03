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

}