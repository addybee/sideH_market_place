<?php
session_start();
if (!$_SESSION["loggedin"]) {
	header("location:../login/login.php");
	exit();
}
include("validate.php");
?>
<!DOCTYPE html>
<html>

<head>
	<title>add item</title>
	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="../market.css" />

</head>

<body class="grey lighten-4">

	<nav class="white z-depth-0">
		<div class="container">

			<a href="../index.php" class="brand-logo brand-text">Bobby Store</a>

			<ul id="nav-mobile" class="right hide-on-small-and-down">

				<li><a href="add_item.php" class="btn brand z-depth-0">Add item</a></li>

				<li><a href="../my_product.php" class="btn brand z-depth-0">My Product</a></li>
				<li><a href="../logout.php" class="btn brand z-depth-0">log out</a></li>

			</ul>
		</div>
	</nav>
	<section class="container grey-text">
		<h4 class="center">Add an item</h4>
		<form class="white" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">

			<label>Item Name</label>
			<input type="text" name="item" value="<?php echo htmlspecialchars($item) ?>">
			<span class="red-text"><?php echo $errors['item']; ?></span>

			<label>Price</label>
			<input type="text" name="price" pattern="^#\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" value="<?php echo htmlspecialchars($price) ?>" placeholder="#1,000,000.00">
			<span class="red-text"><?php echo $errors['price']; ?></span>
			<div class="center">
				<input type="submit" name="submit" class="btn brand z-depth-0">
			</div>
			<div>
				<span> <?php echo $errors["msg"]; ?> </span>
			</div>

		</form>
	</section>
	<?php include("../templates/footer.php"); ?>

</html>