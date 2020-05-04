<?php
	require("conexion.php");
	
	//Valido que haya una accion a realizar
	if( isset( $_GET["action"] ) ){
		$action = $_GET["action"];
	} else {
		$action = "add";
	}

	//Valido que tipo de peticion invoca al modulo
	if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
		//Aca se deben procesar los datos del formulario ejecutado
		require("../init.php");
		require("functions.php");
		
		switch ($action) {
			case 'add':
				$name = $_POST["name"];
				$price =  $_POST["price"];
				$description =  $_POST["description"];
				$category =  $_POST["category"];
				$stock =  $_POST["stock"];
				$image = $_FILES["image"];
				
				CreateProduct($name, $price, $description, $category,  $stock, $image);
			break;
			
			case 'update':
				$id = $_POST["id"];
				$name = $_POST["name"];
				$price =  $_POST["price"];
				$description =  $_POST["description"];
				$category =  $_POST["category"];
				$stock =  $_POST["stock"];

				$image = $_FILES["image"];
				$currentImage = $_POST["currentImage"];
				
				UpdateProduct($id, $name, $price, $description, $category,  $stock, $image, $currentImage);
			break;
			
			case 'delete':
				$id = $_POST["id"];
				$currentImage = $_POST["currentImage"];

				DeleteProduct($id, $currentImage);
			break;
		}

	} else {
		//Preparar el formulario para: Agregar - Modificar - Eliminar

		switch ($action) {
			case 'add':
				$btn = "add";
				$status = null;
				$product = GetProduct();
			break;
			
			case 'update':
				$id = $_GET["id"];
				$btn = "update";
				$status = null;
				$product = GetProduct( $id );
			break;

			case 'delete':
				$id = $_GET["id"];
				$btn = "delete";
				$status = "disabled";
				$product = GetProduct( $id );
			break;
		}
	}
?>
<main>
	<form action="admin/product.php?action=<?php echo $action; ?>" method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<span>Name</span>
			<input class="form-control input-form" type="text" name="name" 
				value="<?php echo $product["name"]; ?>" <?php echo $status; ?>>
			
			<span>Category</span>
			<select class="form-control input-form" name="category" <?php echo $status; ?>>
				<option >Choose a category...</option>
				<?php
					$categories = $conexion->prepare("SELECT * FROM categories");
					$categories->execute();
					while ( $category = $categories->fetch() ) {
				?>
					<option value="<?php echo $category["idCategory"]; ?>" <?php if($category["idCategory"] == $product["category"]) echo "selected" ?>><?php echo $category["name"]; ?></option>
				<?php } ?>
			</select>
			
			<span>Description</span>
			<input class="form-control input-form" type="text" name="description" value="<?php echo $product["description"]; ?>" <?php echo $status; ?>>

			<span>Stock</span>
			<input class="form-control input-form" type="number" name="stock" value="<?php echo $product["stock"]; ?>" <?php echo $status; ?>>
			
			<span>Price</span>
			<input class="form-control input-form" type="text" name="price" value="<?php echo $product["price"]; ?>" <?php echo $status; ?>>

		<?php if( !empty( $product["image"] ) ) : ?>
			<div style="width:100px">
				<img src="<?php echo UPLOADS_URL . "/" . $product["image"]; ?>" style="max-width:100%">
			</div>
		<?php endif; ?>
			<span>Image</span>
			<input type="file" name="image">

			<input class="btn btn-light btn-big" type="submit" value="<?php echo $btn; ?>">

		<?php if( isset($id) ){ ?>
			<input type="hidden" name="id" value="<?php echo $product["idProduct"]; ?>">
			<input type="hidden" name="currentImage" value="<?php echo $product["image"]; ?>">
		<?php } ?>
		</div>
	</form>
</main>