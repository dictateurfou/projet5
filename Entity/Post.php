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

}