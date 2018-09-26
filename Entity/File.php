<?php


namespace Entity;

class File
{
	private $name;
	private $type;
	private $tmp_name;
	private $error;
	private $size;
	const UPLOADFOLDER = __DIR__."/../assets/img/";

	/*only construct with $_Files['names']*/
	function __construct($array){
		if($array !== null){
			foreach($array as $key => $value){
				$this->$key = $value;
			}
		}
	}

	public function getName(){
		return $this->name;
	}

	public function getType(){
		return $this->type;
	}

	public function getTmpName(){
		return $this->tmp_name;
	}

	public function getError(){
		return $this->error;
	}

	public function getSize(){
		return $this->size;
	}

	public function checkType(){
		return strtolower(substr(strrchr($this->name,'.'),1));
	}

	public function checkValidExtension($array){
		$valid = false;
		foreach ($array as $key => $value) {
			if($value === $this->checkType()){
				$valid = true;
				break;
			}
		}
		return $valid;
	}

	public function changeFolder($target){
		
		move_uploaded_file($this->getTmpName(),self::UPLOADFOLDER.$target);
		$this->tmp_name = self::UPLOADFOLDER.$target;
	}


}