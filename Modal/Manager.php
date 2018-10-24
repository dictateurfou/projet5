<?php
namespace Modal;
use PDO;
abstract class Manager{

	const DSN = 'mysql:dbname=surviveigh44;host=surviveigh44.mysql.db';
	const USER = 'surviveigh44';
	const PASS = 'Geneston44';

	protected function cnx(){
		try {
		    $dbh = new PDO(self::DSN, self::USER, self::PASS);
		} catch (PDOException $e) {
		    echo 'Connexion échouée : ' . $e->getMessage();
		}
		return $dbh;
	}

}

