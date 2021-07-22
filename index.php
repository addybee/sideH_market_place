<?php
 session_start();
if (!$_SESSION["loggedin"]) {
    header("location:login/login.php");
    exit();
}
//echo $_SESSION["loggedin"];
include('config/db_connect.php');
// write query for all product
$sql = 'SELECT id, item, price, users_id FROM product ORDER BY posted_at ASC';

// get the result set (set of rows)
$result = $conn->query($sql);

// fetch the resulting rows as an array
$product = $result->fetch_all(MYSQLI_ASSOC);

// free the $result from memory 
$result->free_result();

// close connection
$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Bobby Store</title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="market.css" />

</head>

<body class="grey lighten-4">
    <!-- OUTPUT PRODUCT IN THE DB -->
    <h3 class="grey-text">Hello <?php echo $_SESSION['first_name']."!!";?></h3><br>
    <h4 class="center grey-text">products!!</h4><br>

    <div class="container">
        <div class="row">

            <?php foreach ($product as $prod) : ?>

                <div class="col s6 m4">
                    <div class="card z-depth-0">

                        <div class="card-content center">
                            <h6><?php echo htmlspecialchars($prod['item']); ?></h6>
                            <div><?php echo htmlspecialchars($prod['price']); ?></div>
                        </div>
                        <div class="card-action right-align">
                            <a class="brand-text" href="details.php?id=<?php echo $prod['id'] ?>">more info</a>
                        </div>
                    </div>
                </div><br>

            <?php endforeach; ?>
        </div>
    </div>

    <!-- navigation bar -->
    <nav id= "nav-bar" class="white z-depth-0">
        <div class="container">

            <a href="index.php" class="brand-logo brand-text">Bobby Store</a>

            <ul id="nav-mobile" class="right hide-on-small-and-down">
            <li><a href="login/reset_pwd.php" class="btn brand z-depth-0">reset password</a></li>
                <li><a href="items/add_item.php" class="btn brand z-depth-0">Add item</a></li>
                <li><a href="my_product.php" class="btn brand z-depth-0">My Product</a></li>
                <?php if($_SESSION['loggedin']):?>
                    <li><a href="logout.php" class="btn brand z-depth-0">log out</a></li>
                <?php else:?>
                    <li><a href="logout.php" class="btn brand z-depth-0">log out</a></li>
                <?php endif ?>
            </ul>
        </div>
    </nav>

    <?php include("templates/footer.php"); ?>

</html>