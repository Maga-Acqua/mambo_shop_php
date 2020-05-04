<?php
	if ( isset( $_GET["page"] ) ) {
		$page = $_GET["page"];
	} else {
		$page = "start";
	}
	require_once("admin/functions.php");
	include("header.php");
?>
<section id="page">
	<?php LoadPage( $page ); ?>
</section>
<?php include("footer.php"); ?>