<?php	
	ValidateSession();

	include("conexion.php");
	if (isset( $_GET["rta"]) ) {
		echo ShowMessage( $_GET["rta"] );
	}
	if ( isset($_GET["p"]) ) {
		$page = $_GET["p"];
	} else {
		$page = 1;
	}
?>
<h3>List of products</h3>
<a href="admin/?page=product&amp;action=add" class="register-link">New product</a>
<?php ListProducts($page, 5); ?>