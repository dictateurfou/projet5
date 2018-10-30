<?php
namespace Entity;

class Comment
{
	private $id;
	private $author;
	private $post;
	private $content;
	private $valid;
	private $date;

    public function getProperties(){
        return get_object_vars($this);
    }

    public function getAuthor(){
    	return $this->author;
    }

	public function setId($id){
		$this->id = $id;
	}

	public function setAuthor($author){
		$this->author = $author;
	}

	public function setPost($post){
		$this->post = $post;
	}

	public function setContent($content){
		$this->content = $content;
	}

	public function setValid($valid){
		$this->valid = $valid;
	}

	public function setDate($date){
		$this->date = $date;
	}

	public function getId(){
		return $this->id;
	}


}