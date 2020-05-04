<main> 
<?php
	if (isset( $_GET["rta"]) ) {
		echo MostrarMensaje( $_GET["rta"] );
	}
?>
	<!-- DIV FORM-GROUP -->
	<div class="form-group">
			<h3>Contact us</h3>
			<!-- DIV CONTACT-FORM -->
			<div class="contact-form">
				<form action="send.php" method="POST">
					<input type="text" class="form-control input-form" name="name" placeholder="Name">
					<input type="email" class="form-control input-form" name="email" placeholder="site@mail.com">
					<textarea class="form-control input-form" name="message" placeholder="Your message..."></textarea>
					<button type="submit" class="btn btn-light btn-big contact-btn"><i class="fas fa-paper-plane"></i> Send</button>
				</form>
			</div>
			<!-- // DIV CONTACT-FORM -->
	</div>
	<!--// DIV FORM-GROUP -->	
</main>