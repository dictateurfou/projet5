<?php
namespace Modal;
use PDO;
abstract class Manager{

	const DSN = 'mysql:dbname=projet5;host=localhost';
	const USER = 'root';
	const PASS = '';

	protected function cnx(){
		try {
		    $dbh = new PDO(self::DSN, self::USER, self::PASS);
		} catch (PDOException $e) {
		    echo 'Connexion échouée : ' . $e->getMessage();
		}
		return $dbh;
	}

}

