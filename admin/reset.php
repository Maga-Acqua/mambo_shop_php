<?php
	ValidateSession(true);
	if( isset($_GET["u"]) && isset($_GET["k"]) ){
		$action = "savePass";
		$email = $_GET["u"];
		$key = $_GET["k"];
	} else {
		$action = "recoveryUser";
	}

?>
		<h3>Recover your account</h3>
		<form action="<?php echo BACK_END_URL . "/user.php?action=" . $action; ?>" method="POST">
			<div class="form-group">
				<?php if( $action == "recoveryUser" ) { ?>
				
					<span>E-mail</span>
					<input type="email" name="email" class="form-control input-form"> 
			
				<?php } else { ?>
				<div>
					<span>Enter a new password</span>
					<input type="password" name="pass" class="form-control input-form">
					<input type="hidden" name="email" value="<?php echo $email; ?>"> 
					<input type="hidden" name="key" value="<?php echo $key; ?>"> 
				</div>
				<?php } ?>
					<button type="submit" class="btn btn-light btn-big contact-btn"><i class="fas fa-paper-plane"></i> Send</button>
			</div>
		</form>
