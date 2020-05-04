<?php
	include("conexion.php");

	function LoadPage($page){
		
		$modulo = "./" . $page . ".php";
		if ( file_exists( $modulo ) ) {
			include( $modulo );
		} else {
			include( "404.php" );
		}
	}
	
	function ShowMessage($cod){

		switch ($cod) {
			case '0x001':
				$message = "Name invalid or wrong";
			break;
			
			case '0x002':
				$message = "E-mail invalid or wrong";
			break;

			case '0x003':
				$message = "Message invalid";
			break;

			case '0x004':
				$message = "Your request has been sent... Thanks you!";
			break;

			case '0x005':
				$message = "An error has occurred. Please try again later";
			break;

			case '0x006':
				$message = "Success! A new product has been created";
			break;

			case '0x007':
				$message = "Error ocurred trying to create the product";
			break;

			case '0x008':
				$message = "Success! Product updated";
			break;

			case '0x009':
				$message = "Error ocurred trying to update the product";
			break;

			case '0x010':
				$message = "Success! The product has been deleted";
			break;

			case '0x011':
				$message = "Error ocurred trying to delete the product";
			break;

			case '0x012':
				$message = "Error ocurred trying to upload the image";
			break;

			case '0x013':
				$message = "User already exists";
			break;

			case '0x014':
				$message = "Success! Check your e-mail to activate your account";
			break;

			case '0x015':
				$message = "An error has occurred during the registration. Please try again later";
			break;

			case '0x016':
			case '0x017':
				$message = "Activation error. Please try again later";
			break;

			case '0x018':
				$message = "Success! Your account has been activated";
			break;

			case '0x019':
				$message = "User or password invalid or wrong";
			break;

			case '0x020':
				$message = "Log in successful!";
			break;

			case '0x021':
				$message = "Session ended";
			break;

			case '0x022':
				$message = "Check your e-mail to recover your account";
			break;

			case '0x023':
				$message = "Error! E-mail invalid or wrong";
			break;

			case '0x024':
				$message = "Password updated successfully";
			break;

			case '0x025':
				$message = "Error! Password invalid";
			break;

			case '0x026':
				$message = "Error! Update password denied";
			break;
		}
		return "<p class='rta rta-".$cod."'>".$message."</p>";
	}
	//Back-End Functions
	function showProducts($page = 0, $limit = 10){ ?>
		<?php
			global $conexion;
			$position = ($page - 1) * $limit;
			
			$products = $conexion->prepare("SELECT P.idProduct, P.name, P.price, P.description, P.category, P.stock, P.image, C.name AS category FROM products AS P INNER JOIN categories AS C ON P.category = C.idCategory LIMIT :position, :fils");
			$products->bindParam(":position", $position, PDO::PARAM_INT);
			$products->bindParam(":fils", $limit, PDO::PARAM_INT);
			$products->execute();
			while ( $product = $products->fetch() ) {
			?>
			<div class="feature-grid">
				<a href="./?page=product">
					<img src="<?php echo UPLOADS_URL . "/" . $product["image"]; ?>" class="img-responsive watch-right" alt=""/>
				</a>
				<div class="arrival-info">
					<h4><?php echo $product["category"]; ?> - <?php echo $product["name"]; ?></h4>
					<span class="price">Price: $<?php echo $product["price"]; ?> - Description: <?php echo $product["description"]; ?></span>
					<span class="disc">Stock: <?php echo $product["stock"]; ?></span>
				</div>
			</div>
			<?php
			}
		?>
	<?php
		ShowPager($page, $limit);
	} //End ShowProducts()

	/*function showProducts(){
		if ( ($fichero = fopen("listProducts.csv", "r")) !== FALSE ) {
    		while ( ($datos = fgetcsv($fichero, 1000)) !== FALSE) {
    		?>
			<div class="feature-grid">
				<a href="./?page=product">
					<img src="images/<?php echo $datos[0]; ?>.jpg" class="img-responsive watch-right" alt=""/>
				</a>
				<div class="arrival-info">
					<h4><?php echo $datos[4]; ?> - <?php echo $datos[1]; ?></h4>
					<span class="price">Price: $<?php echo $datos[2]; ?> - Description: <?php echo $datos[3]; ?></span>
					<span class="disc">Stock: <?php echo $datos[5]; ?></span>
				</div>
			</div>
	
			<?php
    		}
    	}
    }*/

	function CreateProduct($name, $price, $description, $category, $stock, $image){
		global $conexion;
		$rta = "0x007"; //"Error ocurred trying to create the product";
		$directory = UPLOADS . "/" . $image["name"];

		if( move_uploaded_file( $image["tmp_name"], $directory ) == true ){
			$product = $conexion->prepare("INSERT INTO products (name, price, description, category, stock, image) VALUES (:name, :price, :description, :category, :stock, :image)");

			$product->bindParam(":name", $name, PDO::PARAM_STR);
			$product->bindParam(":price", $price, PDO::PARAM_STR);
			$product->bindParam(":description", $description, PDO::PARAM_STR);
			$product->bindParam(":category", $category, PDO::PARAM_INT);
			$product->bindParam(":stock", $stock, PDO::PARAM_INT);
			$product->bindParam(":image", $image["name"], PDO::PARAM_STR);

			if ( $product->execute() ) { $rta = "0x006"; } //"Success! A new product has been created";

		} else {
			$rta = "0x012"; //"Error ocurred trying to upload the image";
		} 
		header("location: " . BACK_END_URL . "/?rta=" . $rta);
	} // End function createProduct()

	function UpdateProduct($id, $name, $price, $description, $category, $stock, $image, $currentImage){
		global $conexion;
		$rta = "0x009"; //"Error ocurred trying to update the product";

		if( $image["error"] == 0 ){

			$directory = UPLOADS . "/" . $image["name"];

			if( move_uploaded_file( $image["tmp_name"], $directory ) == true ){
				$sqlImage = $image["name"];
				unlink( UPLOADS . "/" . $currentImage );
			}
		} else {
			$sqlImage = $currentImage;
		}

		$product = $conexion->prepare("UPDATE products SET name = :name, price = :price, description = :description, category = :category, stock = :stock, image = :image WHERE idProduct = :id");
					
		$product->bindParam(":id", $id, PDO::PARAM_INT);
		$product->bindParam(":name", $name, PDO::PARAM_STR);
		$product->bindParam(":price", $price, PDO::PARAM_STR);
		$product->bindParam(":description", $description, PDO::PARAM_STR);
		$product->bindParam(":category", $category, PDO::PARAM_INT);
		$product->bindParam(":stock", $stock, PDO::PARAM_INT);
		$product->bindParam(":image", $sqlImage, PDO::PARAM_INT);

		if ( $product->execute() ) {
			$rta = "0x008"; //"Success! Product updated";
		}
		header("location: " . BACK_END_URL . "/?rta=" . $rta);
	} // End function UpdateProduct()
	
	function DeleteProduct($id, $currentImage){
		global $conexion;
		$rta = "0x011"; //"Error ocurred trying to delete the product";
		$id = $_POST["id"];
		$product = $conexion->prepare("DELETE FROM products WHERE idProduct = :id");
		
		$product->bindParam(":id", $id, PDO::PARAM_INT);

		if ( $product->execute() ) {
			$rta = "0x010"; //"Success! The product has been deleted";
			unlink( UPLOADS . "/" . $currentImage );
		}
		header("location: " . BACK_END_URL . "/?rta=" . $rta);
	} //End DeleteProduct()
	
	function GetProduct($id = 0){
		$product = array(
			"idProduct" => "",
			"name" => "",
			"price" => "",
			"description" => "",
			"category" => "",
			"stock" => "",
			"image" =>""
		);
		if( $id != 0 ) {
			global $conexion;
			$id = $_GET["id"];
			$product = $conexion->prepare("SELECT * FROM products WHERE idProduct = :id");
			$product->bindParam(":id", $id, PDO::PARAM_INT);
			if ( $product->execute() ) {
				$product = $product->fetch();
			}
		}
		return $product;
	} // End function GetProduct()
	
	function ListProducts($page = 0, $limit = 10){ ?>
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">Image</th>
					<th scope="col">Name</th>
					<th scope="col">Price</th>
					<th scope="col">Description</th>
					<th scope="col">Category</th>
					<th scope="col">Stock</th>
					<th scope="col" colspan="2">Actions</th>
				</tr>
			</thead>
		<?php
			global $conexion;
			$position = ($page - 1) * $limit;
			
			$products = $conexion->prepare("SELECT P.idProduct, P.name, P.price, P.description, P.category, P.stock, P.image, C.name AS category FROM products AS P INNER JOIN categories AS C ON P.category = C.idCategory LIMIT :position, :fils");
			$products->bindParam(":position", $position, PDO::PARAM_INT);
			$products->bindParam(":fils", $limit, PDO::PARAM_INT);
			$products->execute();
			while ( $product = $products->fetch() ) {
			?>
			<tbody>
				<tr>
					<td ><img style="max-width:100px" src="<?php echo UPLOADS_URL . "/" . $product["image"]; ?>"></td>
					<td><?php echo $product["name"]; ?></td>
					<td>$<?php echo $product["price"]; ?></td>
					<td><?php echo $product["description"]; ?></td>
					<td><?php echo $product["category"]; ?></td>
					<td><?php echo $product["stock"]; ?></td>
					<td>
						<a class="register-link" href="admin/?page=product&amp;action=update&amp;id=<?php echo $product["idProduct"]; ?>">Update</a>
					</td>
					<td>
						<a class="register-link" href="admin/?page=product&amp;action=delete&amp;id=<?php echo $product["idProduct"]; ?>">Delete</a>
					</td>
				</tr>
			</tbody>
			<?php
			}
		?>
		</table>
	<?php
		ShowPager($page, $limit);
	} //End ListProducts()

	function ShowPager($page = 0, $limit = 10){
		global $conexion;
		$products = $conexion->prepare("SELECT COUNT(*) FROM products");
		$products->execute();
		$total_fils = $products->fetchColumn();		

		//It begins at 0
		$position = ($page - 1) * $limit;

		//total pages to show
		$total_pages = ceil($total_fils / $limit);
?>
			<ul class="pagination">
				<?php if ($page != 1) : ?>
					<li class="page-item"><a class="page-link register-link" href="<?php echo BACK_END_URL . "?p=" . ($page - 1); ?>">Previous</a></li>
				<?php endif; ?>

				<?php 
					for ($i=1; $i <= $total_pages; $i++) { 
						
						if ($page == $i) {
							$href = "#";
						} else {
							$href = BACK_END_URL . "/?p=".$i;
						}
						echo "<li class='page-item'><a class='page-link register-link' href='".$href."'>".$i."</a></li>\n";
					}
				 ?>
				<?php if ($page != $total_pages) : ?>
					<li class="page-item"><a class="page-link register-link" href="<?php echo BACK_END_URL . "/?p=" . ($page + 1); ?>">Next</a></li>
				<?php endif; ?>
			</ul>
<?php
	} //End ShowPager()
	
	function RegisterUser($name, $lastname, $email, $pass){
		global $conexion;
		$rta = "0x013"; //"User already exists";
		$user = $conexion->prepare("SELECT * FROM users WHERE email = :email");
		$user->bindParam(":email", $email, PDO::PARAM_STR);
		$user->execute();

		if ( $user->rowCount() == 0 ) {

			$hash = password_hash($pass, PASSWORD_DEFAULT);
			
			$string = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789ª!·$%&/()=?¿*^¨ç_:;\|@#~€¬][}{}]";
			$key = str_shuffle( $string ); //Randomly shuffle a string
			$key = md5( $key );

			$user = $conexion->prepare("INSERT INTO users (name, lastname, email, pass, activation) VALUES (:name, :lastname, :email, :pass, :activation)");

			$user->bindParam(":name", $name, PDO::PARAM_STR);
			$user->bindParam(":lastname", $lastname, PDO::PARAM_STR);
			$user->bindParam(":email", $email, PDO::PARAM_STR);
			$user->bindParam(":pass", $hash, PDO::PARAM_STR);
			$user->bindParam(":activation", $key, PDO::PARAM_STR);
				
			if ( $user->execute() ) {
				$url_activation = BACK_END_URL . "/";
				$url_activation.= "user.php";
				$url_activation.= "?u=" . $email;
				$url_activation.= "&k=" . $key;
				$url_activation.= "&action=activeUser";

				$body = "<h1>Welcome to Mambo! E-shop</h1>";
				$body.= "<br>";
				$body.= "Name: " . $name;
				$body.= "<br>";
				$body.= "Lastname: " . $lastname;
				$body.= "<br>";
				$body.= "User: " . $email;
				$body.= "<br>";
				$body.= "<p>Please, activate your account to use our plataform.</p>";
				$body.= "<a style='background-color:blue;color:white;display:block;padding:10px' href='".$url_activation."'>Activate my account</a>";

				$header = "From: no-reply@" . $_SERVER["SERVER_NAME"] . "\r\n";
				$header.= "MIME-Version: 1.0" . "\r\n";
				$header.= "Content-Type: text/html; charset=utf-8" . "\r\n";

				echo $body;
				die();
				$rta = "0x014"; //"Success! Check your e-mail to activate your account";
			} else {
				$rta = "0x015"; //"An error has occurred during the registration. Please try again later";
			}
		}
		header("location: " . BACK_END_URL . "/?page=register&rta=" . $rta);
	} //End RegisterUser()
	
	function ActivateUser($email, $key){
		global $conexion;
		$rta = "0x016"; //"Activation error. Please try again later";

		$user = $conexion->prepare("SELECT * FROM users WHERE email = :email AND activation = :activation");
		$user->bindParam(":email", $email, PDO::PARAM_STR);
		$user->bindParam(":activation", $key, PDO::PARAM_STR);

		if ( $user->execute() ) {
			
			$user = $conexion->prepare("UPDATE users SET state = 1 WHERE email = :email");
			$user->bindParam(":email", $email, PDO::PARAM_STR);

			if ( $user->execute() ) {
				$rta = "0x018";//"Success! Your account has been activated";
			} else {
				$rta = "0x017";//"Activation error. Please try again later";
			}
		}
		header("location: " . BACK_END_URL . "/?page=login&rta=" . $rta);
	} //End ActivateUser()

	function BeginSession($email, $pass){
		global $conexion;
		
		$rta = "0x019";//"User or password invalid or wrong";
		$ruta = "login";

		$user = $conexion->prepare("SELECT * FROM users WHERE email = :email AND state = 1");
		$user->bindParam(":email", $email, PDO::PARAM_STR);

		if ( $user->execute() && $user->rowCount() > 0 ) {

			$user = $user->fetch();

			if (password_verify($pass, $user["pass"])) {
				session_start();
				$_SESSION["user"] = array(
					"name" => $user["name"],
					"lastname" => $user["lastname"],
					"email" => $user["email"]
				);
				$rta = "0x020";//"Log in successful!";
				$ruta = "dashboard";
			}
		}
		header("location: " . BACK_END_URL . "/?page=".$ruta."&rta=" . $rta);
	}// End BeginSession()

	function CloseSession(){
		$rta = "0x021";//"Session ended";

		session_start();
		setcookie(session_name(), '', time() - 42000, '/'); 
		unset( $_SESSION );
		session_destroy();
		header("location: " . BACK_END_URL . "/?page=login&rta=" . $rta);
	} //End CloseSession()

	function RecoverKey( $email ){
		global $conexion;
		$rta = "0x023"; //"Error! E-mail invalid or wrong";

		$user = $conexion->prepare("SELECT * FROM users WHERE email = :email AND state = 1");
		$user->bindParam(":email", $email, PDO::PARAM_STR);

		if ( $user->execute() ) {

			$string = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789ª!·$%&/()=?¿*^¨ç_:;\|@#~€¬][}{}]";
			$key = str_shuffle( $string );
			$key = md5( $key );

			$user = $conexion->prepare("UPDATE users SET activation = :activation WHERE email = :email");
			$user->bindParam(":email", $email, PDO::PARAM_STR);
			$user->bindParam(":activation", $key, PDO::PARAM_STR);

			if ( $user->execute() ) {
				$url_recover = BACK_END_URL . "/";
				$url_recover.= "?page=reset";
				$url_recover.= "&u=" . $email;
				$url_recover.= "&k=" . $key;

				$body = "<h3>Recover your account in Mambo! E-shop</h3>";
				$body.= "<br>";
				$body.= "User: " . $email;
				$body.= "<br>";
				$body.= "<p>Please, click the follow link to recover your account</p>";
				$body.= "<a style='text-decoration:none;background-color:rgb(42, 183, 115);color:white;display:block;padding:10px' href='".$url_recover."'>Recover my account</a>";

				$header = "From: no-reply@" . $_SERVER["SERVER_NAME"] . "\r\n";
				$header.= "MIME-Version: 1.0" . "\r\n";
				$header.= "Content-Type: text/html; charset=utf-8" . "\r\n";

				echo $body;
				die();
				$rta = "0x022";//"Check your e-mail to recover your account";
			}
			header("location: " . BACK_END_URL . "/?page=login&rta=" . $rta);
			
		}
	}//  End RecoverKey()

	function SaveKey( $email, $pass, $key ){
		global $conexion;
		$rta = "0x026";
		$user = $conexion->prepare("SELECT * FROM users WHERE email = :email AND activation = :activation");
		$user->bindParam(":email", $email, PDO::PARAM_STR);
		$user->bindParam(":activation", $key, PDO::PARAM_STR);

		if ( $user->execute() ) {
			
			$hash = password_hash($pass, PASSWORD_DEFAULT);

			$user = $conexion->prepare("UPDATE users SET pass = :pass WHERE email = :email");
			$user->bindParam(":email", $email, PDO::PARAM_STR);
			$user->bindParam(":pass", $hash, PDO::PARAM_STR);

			if ( $user->execute() ) {
				$rta = "0x024";//"Password updated successfully";
			} else {
				$rta = "0x025";//"Error! Password invalid";
			}

		}
		header("location: " . BACK_END_URL . "/?page=login&rta=" . $rta);
	}//End SaveKey()

	function ValidateSession($state = false){
		$ruta = $state ? "dashboard" : "login";
		if( isset( $_SESSION["user"] ) == $state ) {
			header("location: " . BACK_END_URL . "/?page=" . $ruta);
		}
	} //End ValidateSession()
?>