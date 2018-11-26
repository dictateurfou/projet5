<?php
namespace Modal;
use PDO;
use PDOException;
abstract class Manager{

	private $dsn;
	private $user;
	private $pass;

	public function __construct(){
		$json = file_get_contents('./config.json');
		$json_data = json_decode($json,true);
		$this->dsn = $json_data['bdd']['dsn'];
		$this->user = $json_data['bdd']['user'];
		$this->pass = $json_data['bdd']['pass'];
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
