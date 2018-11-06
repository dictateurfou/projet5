<?php
namespace Entity;
use PDO;
use \Modal\Manager;
class Utils extends Manager
{
	public function getObjectInObject(string $object,array $subObject,string $cond = null,$param = null){
		$class = '\Entity\\'.ucfirst($object);
		$request = "SELECT ".$object.".*,";
		$allias = "";
		$from = " FROM ".$object;
		$i = 0;
		$join = "";
		foreach ($subObject as $key => $value){
			$join = $join."INNER JOIN ".$value." ON ".$object.".".$key." = ".$value.".id";
			$subClass = '\Entity\\'.ucfirst($value);
			$subEntity = new $subClass;
			$properties = $subEntity->getProperties();
			$e = 0;

			foreach ($properties as $key2 => $value2){
				if($e == 0){
					$allias = $allias.$value.".".$key2." AS ".$value."_".$key2;
				}
				else{
					$allias = $allias.",".$value.".".$key2." AS ".$value."_".$key2;
				}
				$e++;
			}
		}
		
		if($cond !== null){
			$request = $request.$allias.$from." ".$join." ".$cond;
		}
		else{
			$request = $request.$allias.$from." ".$join;
		}
		$cnx = $this->cnx();
		$stmt = $cnx->prepare($request);
		if($param !== null){
			foreach ($param as $key => $value){
			    $stmt->bindParam($key,$value);
			}
		}
		$stmt->execute();
		$result = $stmt->fetchAll();

		$objectTab = array();
		$i = 0;
		while($i < count($result)){
			$tempClass = new $class;
			$createdClass = [];
			foreach ($result[$i] as $key => $value){
				if(strpos($key, '_') == false){
					$method = 'set'.ucfirst($key);
					if (method_exists($tempClass, $method)){
					  $tempClass->$method($value);
					}
				}
				else{
					$keyExplode = explode('_', $key);
					if(!array_key_exists($keyExplode[0], $createdClass)){
						$subTempClass = "\Entity\\".ucfirst($keyExplode[0]);
						$createdClass[$keyExplode[0]] = new $subTempClass;
					}
					$method = 'set'.ucfirst($keyExplode[1]);
					if(method_exists($createdClass[$keyExplode[0]], $method)){
						$createdClass[$keyExplode[0]]->$method($value);
					}
				}

			}

			foreach ($subObject as $key => $value){
				$method = 'set'.ucfirst($key);
				$tempClass->$method($createdClass[$value]);
			}
			array_push($objectTab,$tempClass);
			$i++;
		}

		if(empty($objectTab) == true){
			$objectTab = false;
		}
		return $objectTab;

		/*foreach ($donnees as $key => $value){
			$method = 'set'.ucfirst($key);
			if (method_exists($this, $method)){
			  $this->$method($value);
			}
		}
*/
		/*$stmt = $cnx->prepare("SELECT comment.*,users.name as authorName FROM comment INNER JOIN users ON comment.author = users.id");*/


		/*while($i < count($subObject)){
			$allias = 
			$i++;
		}*/

		/*
		$i = 0;
		while($i < count($donnees)){
			 
			$entity = new $object();
			foreach ($donnees as $key => $value){
				$method = 'set'.ucfirst($key);
				if (method_exists($this, $method)){
				  $this->$method($value);
				}
			}
		$i++;
		}*/

	}

}