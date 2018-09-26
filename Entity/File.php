<?php


namespace Entity;

class File
{
	private $name;
	private $type;
	private $tmp_name;
	private $error;
	private $size;

	/*construct with $_Files['names']*/
	function __construct($array){
		foreach($array as $key => $value){
			$this->$key = $value;
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
		strrchr($other_filename, '.' );
	}


}