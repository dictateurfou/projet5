<?php

namespace Entity;

class Post
{
	private $id;
	private $title;
	private $image;
	private $content;
	private $author;
	private $createdAt;
	private $editedAt;

	public function getId(){
		return $this->id;
	}

	public function getTitle(){
		return $this->title;
	}

	public function getImage(){
		return $this->image;
	}

	public function getContent(){
		return $this->content;
	}

	public function getAuthor(){
		return $this->author;
	}

	public function getCreatedAt(){
		return $this->createdAt;
	}

	public function getEditedAt(){
		return $this->editedAt;
	}

	public function setId($arg){
		$this->id = $arg;
	}

	public function setTitle($arg){
		$this->title = $arg;
	}

	public function setImage($arg){
		$this->image = $arg;
	}

	public function setContent($arg){
		$this->content = $arg;
	}

	public function setAuthor($arg){
		$this->author = $arg;
	}

	public function setCreatedAt($arg){
		$this->createdAt = $arg;
	}

	public function setEditedAt($arg){
		$this->editedAt = $arg;
	}

}
