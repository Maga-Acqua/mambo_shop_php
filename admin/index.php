<?php
	if ( isset( $_GET["page"] ) ) {
		$page = $_GET["page"];
	} else {
		$page = "dashboard";
	}
	require_once("functions.php");
	include("../header.php");
?>
<section id="page">
	<?php LoadPage( $page ); ?>
</section>
<?php include("../footer.php"); ?>