<?php

if( isset( $_GET["action"] ) ){
	include("../init.php");
	include("functions.php");

	
	$action = $_GET["action"];

	switch ($action) {
		case 'addUser':
			$name = $_POST["name"];
			$lastname = $_POST["lastname"];
			$email = $_POST["email"];
			$pass = $_POST["pass"];

			RegisterUser($name, $lastname, $email, $pass);
		break;

		case 'activeUser':
			$email = $_GET["u"];
			$key = $_GET["k"];
			ActivateUser($email, $key);
		break;

		case 'loginUser':
			$email = $_POST["email"];
			$pass = $_POST["pass"];
			BeginSession($email, $pass);
		break;

		case 'logoutUser':
			CloseSession();
		break;

		case 'recoveryUser':
			$email = $_POST["email"];
			RecoverKey( $email );
		break;

		case 'savePass':
			$email = $_POST["email"];
			$pass = $_POST["pass"];
			$key = $_POST["key"];
			SaveKey( $email, $pass, $key );
		break;
	}
}

?>