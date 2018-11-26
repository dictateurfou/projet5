<?php
	session_start();

	require('Entity/Psr4AutoloaderClass.php');
	$loader = new \Entity\Psr4AutoloaderClass;
	$loader->register();
	/*$loader->addNamespace('Blog\Administration', 'src/Blog/Administration/Classes/');*/
	$loader->addNamespace('Entity', 'Entity/');
	$loader->addNamespace('Controller','Controller/');
	$loader->addNamespace('Modal','Modal/');

	$controller = new \Controller\Controller();

	/* Globaly route is writed in this */
	include "include/router.php";

	/*new \Blog\Administration\Test;*/
	/*$entity = new \Entity\UserManager;*/

	echo $controller->render();
	
?>

