<?php 
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

?>

<!DOCTYPE html>
<html>
	<head>
		<title>acceuil</title>
		<link rel="stylesheet" type="text/css" href="assets/css/reset.css">
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	</head>

	<body>

		<header>
			<nav id="menu">
				<a href="#">Acceuil</a>
				<a href="#">Blog</a>
				<a href="#">Connexion</a>
			</nav>
		</header>

		<section id="left-bar">
			<div id="circle-img">
				<img id="photo" src="assets/img/photo.png"/>
			</div>
		</section>

		<section id="content">
			
		</section>
	</body>
</html>