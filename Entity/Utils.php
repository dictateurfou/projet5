<?php
namespace Entity;
use PDO;
use \Modal\Manager;
class Utils extends Manager{

	/*fix sensio labs*/
	const OBJECTLIST = ["comment","post","role","user","utils"];

	public function getObjectInObject(string $object,array $subObject,string $cond = null,$param = null){
		/*fix sensioLabs*/
		$i = 0;
		$objectFix;
		while(count(self::OBJECTLIST) > $i){
			if($object == self::OBJECTLIST[$i]){
				$objectFix = self::OBJECTLIST[$i];
			}
			$i++;
		}
		/*endFix*/
		if($objectFix !== null){
			$class = '\Entity\\'.ucfirst($objectFix);
			$request = "SELECT ".$objectFix.".*,";
			$allias = "";
			$from = " FROM ".$objectFix;
			$i = 0;
			$join = "";
			$firstPassed = false;
			foreach ($subObject as $key => $value){
				$join = $join." INNER JOIN ".$value." ON ".$objectFix.".".$key." = ".$value.".id";
				$subClass = '\Entity\\'.ucfirst($value);
				$subEntity = new $subClass;
				$properties = $subEntity->getProperties();
				$e = 0;
				foreach ($properties as $key2 => $value2){
					if($e == 0 && $firstPassed == false){
						$allias = $allias.$value.".".$key2." AS ".$value."_".$key2;
						$firstPassed = true;
					}
					else{
						$allias = $allias.",".$value.".".$key2." AS ".$value."_".$key2;
					}
					$e++;
				}
			}
			
			if($cond !== null){
				$request = $request.$allias.$from."".$join." ".$cond;
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
		}
	
	}

}
