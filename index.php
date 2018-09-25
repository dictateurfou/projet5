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
	require_once("vendor/autoload.php");

	$loaderTwig = new \Twig_Loader_Filesystem(__DIR__.'/View');
	$twig = new \Twig_Environment($loaderTwig);


?>

<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <title>Clean Blog - Start Bootstrap Theme</title>

	    <!-- Bootstrap core CSS -->
	    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	    <!-- Custom fonts for this template -->
	    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
	    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

	    <!-- Custom styles for this template -->
	    <link href="assets/css/clean-blog.min.css" rel="stylesheet">
	</head>

	<body>

		<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
	      <div class="container">
	        <a class="navbar-brand" href="index.html">Start Bootstrap</a>
	        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          Menu
	          <i class="fas fa-bars"></i>
	        </button>
	        <div class="collapse navbar-collapse" id="navbarResponsive">
	          <ul class="navbar-nav ml-auto">
	            <li class="nav-item">
	              <a class="nav-link" href="index.html">Acceuil</a>
	            </li>
	            <li class="nav-item">
	              <a class="nav-link" href="?post&action=viewAll">Blog</a>
	            </li>
	            <li class="nav-item">
	              <a class="nav-link" href="post.html">Connection</a>
	            </li>

	          </ul>
	        </div>
	      </div>
	    </nav>

     	<header class="masthead" style="background-image: url('assets/img/home-bg.jpg')">
	      <div class="overlay"></div>
	      <div class="container">
	        <div class="row">
	          <div class="col-lg-8 col-md-10 mx-auto">
	            <div class="site-heading">
	              <h1>Clean Blog</h1>
	              <span class="subheading">A Blog Theme by Start Bootstrap</span>
	            </div>
	          </div>
	        </div>
	      </div>
	    </header>

		<section id="left-bar" style="display:none">
			<div id="circle-img">
				<img id="photo" src="/assets/img/photo.png"/>
			</div>

			<h2 id="name">Hervy Steven</h2>
			<p id="introduction">Dévelloppeur full stack capable de réaliser vos application les plus folles seul votre imagination es une limite.</p>
			<a href="https://github.com/dictateurfou"><i class="fab fa-github"></i> github</a>
			<a href="https://www.linkedin.com/in/steven-hervy-67416a157/"> <i class="fab fa-linkedin"></i> linkdin</a>
			<a href="https://codestats.net/users/dictateurfou"><i class="fas fa-code"></i> code stats</a>
		</section>

		<section id="content">
			<?php echo $twig->render($controller->getvue(), $result); ?>
		</section>

		    <!-- Footer -->
	    <footer>
	      <div class="container">
	        <div class="row">
	          <div class="col-lg-8 col-md-10 mx-auto">
	            <ul class="list-inline text-center">
	              <li class="list-inline-item">
	                <a href="#">
	                  <span class="fa-stack fa-lg">
	                    <i class="fas fa-circle fa-stack-2x"></i>
	                    <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
	                  </span>
	                </a>
	              </li>
	              <li class="list-inline-item">
	                <a href="#">
	                  <span class="fa-stack fa-lg">
	                    <i class="fas fa-circle fa-stack-2x"></i>
	                    <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
	                  </span>
	                </a>
	              </li>
	              <li class="list-inline-item">
	                <a href="#">
	                  <span class="fa-stack fa-lg">
	                    <i class="fas fa-circle fa-stack-2x"></i>
	                    <i class="fab fa-github fa-stack-1x fa-inverse"></i>
	                  </span>
	                </a>
	              </li>
	            </ul>
	            <p class="copyright text-muted">Copyright &copy; steven 2018</p>
	          </div>
	        </div>
	      </div>
	    </footer>

		  <!-- Bootstrap core JavaScript -->
	    <script src="assets/vendor/jquery/jquery.min.js"></script>
	    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	    <!-- Custom scripts for this template -->
	    <script src="assets/js/clean-blog.min.js"></script>
	</body>
</html>