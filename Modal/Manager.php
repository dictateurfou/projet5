<?php
namespace Modal;
use PDO;
abstract class Manager{

	private $dsn;
	private $user;
	private $pass;

	function __construct(){
		$json = file_get_contents('./config.json');
		$json_data = json_decode($json,true);
		$this->dsn = $json_data['dsn'];
		$this->user = $json_data['user'];
		$this->pass = $json_data['pass'];
	}

	protected function cnx(){
		try {
			$dbh = new PDO($this->dsn, $this->user, $this->pass);
		} catch (PDOException $e) {
		    echo 'Connexion échouée : ' . $e->getMessage();
		}
		return $dbh;
	}

}

