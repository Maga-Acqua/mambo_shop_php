<?php require_once("init.php"); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Mambo! | E-Shop made with PHP</title>
		<base href="http://<?php echo $_SERVER["SERVER_NAME"] . DIR_RAIZ; ?>/">	
		<!--Responsive-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="theme-color" content="black">
		<!--FontAwesome Icons-->
		<script src="https://kit.fontawesome.com/9422a06d45.js" crossorigin="anonymous"></script>
		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<!--theme-style-->
		<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	</head>
	<body> 
		<!-- Header -->
		<header>
			<!--Nav bar-->
			<nav>
				<!--Responsive nav bar (max-width: 858px)-->
				<input type="checkbox" id="check">
				<label for="check" class="check-btn">
					<i class="fas fa-bars"></i>
				</label>
				<!--// Responsive nav bar-->
				<span><a href="./"><img src="images/logo_mambo_sincircle.svg" id="logo-nav"></a></span>
				<ul>
				<?php
					session_start();
					if ( isset( $_SESSION["user"] ) ) {
				?>
					<li><a href="./admin/?page=dashboard"><span></span> BIENVENID@ <?php echo $_SESSION["user"]["name"]; ?></a></li>
				<?php } else { ?>
					<li><a href="./admin/?page=login">Log in</a></li>
					<li><a href="./admin/?page=register">Sign in</a></li>
				<?php } ?>
					<li><a href="?page=contact">Contact us</a></li>
				</ul>
			</nav>
			<!-- // Nav bar-->
		</header>
		<!--End Header-->
		<main>
			<div class="container">