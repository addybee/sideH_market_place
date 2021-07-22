<?php 
    session_start();
	
    include('config/db_connect.php');
	// check GET request id param
	if(isset($_GET['id'])){
		
		// escape sql chars
		$id = $conn->real_escape_string($_GET['id']);

		// make sql
		$sql = "SELECT * FROM product WHERE id = $id";

		// get the query result
		$result = $conn->query($sql);

		// fetch result in array format
		$product = $result->fetch_assoc();

		$result->free_result();
		$conn->close();
	}
// ?>

<!DOCTYPE html>
<html>

<head>
  <title>more info</title>
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" type="text/css" href="market.css" />

</head>

<body class="grey lighten-4">
    <!-- /navigation bar -->
  <nav class="white z-depth-0">
    <div class="container">

      <a href="index.php" class="brand-logo brand-text">Bobby Store</a>

      <ul id="nav-mobile" class="right hide-on-small-and-down">

        <li><a href="items/add_item.php" class="btn brand z-depth-0">Add item</a></li>

        <li><a href="my_product.php" class="btn brand z-depth-0">My Product</a></li>
        <li><a href="logout.php" class="btn brand z-depth-0">log out</a></li>

      </ul>
    </div>
  </nav>

	<div class="container center grey-text">
		<?php if($product): ?>
			<h4><?php echo $product['item']; ?></h4><br>
			<p>Price: <?php echo $product['price']; ?></p>
			<p>posted on:<?php echo date($product['posted_at']); ?></p>
			
			<p>ProductId: <?php echo $product['id']; ?></p>

			

		<?php else: ?>
			<h5>No such product exists.</h5>
		<?php endif ?>
	</div>

	<?php include('templates/footer.php'); ?>

</html>