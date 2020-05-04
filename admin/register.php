
<?php
	if (isset( $_GET["rta"]) ) {
		echo ShowMessage( $_GET["rta"] );
	}
?>
	<h3>Sign in</h3>
		<form action="<?php echo BACK_END_URL . "/user.php?action=addUser"; ?>" method="POST">
			<div class="form-group">
				<span>Name <label>*</label></span>
				<input type="text" name="nombre" class="form-control input-form"> 

				<span>Lastname <label>*</label></span>
				<input type="text" name="apellido" class="form-control input-form"> 

				<span>E-mail <label>*</label></span>
				<input type="text" name="email" class="form-control input-form">

				<span>Password <label>*</label></span>
				<input type="password" name="pass" class="form-control input-form">

				<input class="btn btn-light btn-big" type="submit" value="Sig in">
			</div>
		</form>
	