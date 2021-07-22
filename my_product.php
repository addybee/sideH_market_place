<?php
session_start();

if (!$_SESSION["loggedin"]) {
    header("location:login/login.php");
    exit();
}

include('config/db_connect.php');
//delete record from product
if (isset($_POST['delete'])) {
    
    $id_to_delete = $conn->real_escape_string($_POST['id_to_delete']);
    $sql = "DELETE FROM product WHERE id = '$id_to_delete' ";
        if ($conn->query($sql) == true) {
        header('Location:my_product.php');
    } else {
        echo 'query error: ' . $conn->error;
    }
}

// escape sql chars
$id = $conn->real_escape_string($_SESSION["id"]);

// write query for all product
$sql = "SELECT id, item, price FROM product WHERE users_id = '$id' ORDER BY posted_at ASC";

// get the result set (set of rows)
$result = $conn->query($sql);

// fetch the resulting rows as an array
$product = $result->fetch_all(MYSQLI_ASSOC);

// free the $result from memory 
$result->free_result();

// close connection
$conn->close();

// 
?>

<!DOCTYPE html>
<html>

<head>
    <title>my product</title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="market.css" />

</head>

<body class="grey lighten-4">
    <!-- navigation bar -->
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


    <h4 class="center grey-text">my products!!</h4>
    <?php if ($product) : ?>
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
                                <a class="brand-text" href="details.php?id=<?php echo $prod['id']; ?>">more info</a>
                                                                                    
                            </div>

                            <a href='<?php echo"items/update.php?item=".urlencode($prod['item'])."&price=".urlencode($prod['price'])."&id=".urlencode($prod['id']);?>'>
                                <button type=submit class="btn brand z-depth-0">update</button>
                            </a>
                            <!-- DELETE FORM and update -->
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <input type="hidden" name="id_to_delete" value="<?php echo $prod['id']; ?>">

                                <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
                            </form>
                            
                        </div>
                    </div><br>

                <?php endforeach; ?>
            </div>
        </div>
    <?php else : ?>

        <h5>No such product exists.</h5>
    <?php endif ?>
    <?php include("templates/footer.php"); ?>

</html>