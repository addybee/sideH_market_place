<?php
    session_start();
    if (!$_SESSION["loggedin"]) {
        header("location:login/login.php");
        exit();
    }
    $price = $id = $item = "";
    $errors = array('item' => '', 'price' => '', 'msg' => ''); 
    $prod = array('id'=>'', 'item' => '', 'price' => '');
    //connect to database
    include('../config/db_connect.php');
    if (isset($_POST['update'])) {
        
        // check item
        if (empty($_POST['item'])) {
            $errors['item'] = 'A item is required';
        } else {
            $item = $_POST['item'];
            if (!preg_match('/^[a-zA-Z\d\s]+$/', $item)) {
                $errors['item'] = 'item must be letters, number and spaces only';
            }
        }
            // check price
            if (empty($_POST['price'])) {
                $errors['price'] = 'price is required';
            } else {
                $price = $_POST['price'];

                if (!preg_match("/^(#)\d{1,3}(\,\d{3})*(\.\d+)?$/", $price)) {
                    $errors['price'] = "invalid price";
                }
            }
            
            if (!array_filter($errors)) {
                //connect to database

                $item = $conn->real_escape_string($item);
                $price = $conn->real_escape_string($price);
                $id = $conn->real_escape_string($_POST['id_update']);

                //update database with form input
                $sql = "UPDATE product SET item= '$item', price = '$price' WHERE id = '$id' ";
                
                if ($conn->query($sql) === true) {
                    
                    header("location:../my_product.php");
                } else {
                    echo $conn->error;
                }
            }
    }
    // check GET request id param
	if(isset($_GET['id'])){
		
		$prod['id']=$_GET['id'];
        $prod['item']=$_GET['item'];
        $prod['price']=$_GET['price'];
	}
    
    $conn->close();

?>

<!DOCTYPE html>
<html>

<head>
	<title>update item</title>
	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="../market.css" />

</head>

<body class="grey lighten-4">

	<nav class="white z-depth-0">
		<div class="container">

			<a href="../index.php" class="brand-logo brand-text">Bobby Store</a>

			<ul id="nav-mobile" class="right hide-on-small-and-down">

				<li><a href="../my_product.php" class="btn brand z-depth-0">My Product</a></li>
				<li><a href="../logout.php" class="btn brand z-depth-0">log out</a></li>

			</ul>
		</div>
	</nav>
	<section class="container grey-text">
		<h4 class="center">update an item</h4>
		<form class="white" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">

			<input type="hidden" name= "id_update" value="<?php echo $prod['id'];?>">
            <label>Item Name</label>
			<input type="text" name="item" value="<?php echo ($prod['item']); ?>">
			<span class="red-text"><?php echo $errors['item']; ?></span>

			<label>Price</label>
			<input type="text" name="price" pattern="^#\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" value="<?php echo ($prod['price']); ?>" placeholder="#1,000,000.00">
			<span class="red-text"><?php echo $errors['price']; ?></span>
			<div class="center">
				<input type="submit" name="update" value= "update" class="btn brand z-depth-0">
			</div>
			<div>
				<span> <?php echo $errors["msg"]; ?> </span>
			</div>

		</form>
	</section>
	<?php include("../templates/footer.php"); ?>

</html>
