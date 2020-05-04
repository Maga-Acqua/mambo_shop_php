<?php 
	ValidateSession(true); 

	if (isset( $_GET["rta"]) ) {
		echo ShowMessage( $_GET["rta"] );
	}
?>
	<div>
		<h3>Log in</h3>
		<form action="<?php echo BACK_END_URL . "/user.php?action=loginUser"; ?>" method="POST">
			<div class="form-group">
				<div>
					<span>E-mail</span>
					<input type="text" name="email" class="form-control input-form"> 
				</div>
				<div>
					<span>Password</span>
					<input type="password" name="pass" class="form-control input-form"> 
				</div>
				<input type="submit" value="Log in" class="btn btn-light btn-big">
				<a class="register-link" href="<?php echo BACK_END_URL . '/?page=reset'; ?>">Forgot your password?</a>
			</div>
		</form>
	</div>

	<div>
	
		<h3>Are you new here?</h3>
		<a class="register-link" href="<?php echo BACK_END_URL . '/?page=register'; ?>">Sign in</a>
	</div>
</div>