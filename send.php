<?php
	if ( $_SERVER["REQUEST_METHOD"] == "POST") {
		//1) Get the values from POST
		$name = $_POST["name"];
		$email = $_POST["email"];
		$message = $_POST["message"];
		
		if( empty($name) || strlen( $name ) < 5 || is_numeric( $name ) || is_numeric( substr($name, 0, 1) ) ) {
			//echo "Name invalid";
			header("location: ./?page=contact&rta=0x001");
	  //} elseif ( $email == "" || strpos($email, "@") === false &&  strpos($email, ".") === false ) {
		} elseif ( $email == "" || filter_var($email, FILTER_VALIDATE_EMAIL) === false ) {
			//echo "Email invalid";
			header("location: ./?page=contact&rta=0x002");
		} elseif ( empty( $message ) || strlen( $message ) > 400 ) {
			//echo "Message invalid";
			header("location: ./?page=contact&rta=0x003");
		} else {
			$cuerpo = "<h1>Mambo! - Contact details</h1>";
			$cuerpo.= "<p><strong>Name:</strong> " . $name . "</p>";
			$cuerpo.= "<p><strong>E-Mail:</strong> " . $email . "</p>";
			$cuerpo.= "<p><strong>Message:</strong></p>";
			$cuerpo.= "<blockquote>" . $message . "</blockquote>";

			//3) Build the header
			$cabecera = "From:" . $email . "\r\n";
			$cabecera.= "MIME-Version: 1.0\r\n";
			$cabecera.= "Content-Type: text/html; charset=UTF-8\r\n";

			$destinatario = "contact@mamboarte.com"; //Change to the valid one!

			$asunto = "Contact from Mambo! E-Shop";

			//4) Send the email
			if ( mail($destinatario, $asunto, $cuerpo, $cabecera) === true ) {
				//echo "E-Mail send";
				header("location: ./?page=contact&rta=0x004");
			} else {
				//echo "E-Mail no send";
				header("location: ./?page=contact&rta=0x005");
			}
		}

	} else {
		header("location: ./?page=contact");
	}

?>