<?php 
	include("admin/conexion.php");
	if (isset( $_GET["rta"]) ) {
		echo ShowMessage( $_GET["rta"] );
	}
	if ( isset($_GET["p"]) ) {
		$page = $_GET["p"];
	} else {
		$page = 1;
	}
?>

<h3>All our products</h3>
	<div class="row">
		<div class="col search">
			<form>
				<input class="form-control" type="search" placeholder="" aria-label="Search">
				<button class="btn btn-light" type="submit"><i class="fas fa-search"></i></button> 
			</form>
		</div>
		<div class="col search">
			<div class="show-more">
				<h4>Last season!
				<a href="?page=products">+ see more products</a>
			</div>
		</div>
	</div>
		<div class="container">
			<!-- Bootstrap Row-->
			<div class="row">
				<div class="col-6 col-md-4">
				<?php showProducts($page, 5); ?>
			<!-- // Bootstrap Row-->
		</div>