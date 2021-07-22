<?php
include("validate_login.php");

?>
<!DOCTYPE html>
<html>

<head>
    <title>login</title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="../market.css" />

</head>

    <body class="grey lighten-4">
        <!-- /navigation bar -->
        <nav class="white z-depth-0">
        <div class="container">
        
        <a href="../index.php" class="brand-logo brand-text">Bobby Store</a>
        
        <ul id="nav-mobile" class="right hide-on-small-and-down">
            
            <li><a href="#" class="btn brand z-depth-0">about</a></li>
            <li><a href="#" class="btn brand z-depth-0">contact</a></li>     
            <li><a href="login.php" class="btn brand z-depth-0">loggin</a></li>
            
        </ul>
        </div>
    </nav>

                <!-- form input -->
        <div class="container">
            <div class="container">
                <h2>Login</h2>
                <p>Please fill this form to login into your account.</p>
            </div>

            <div class="container">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    
                        
                        <div>
                            <label for="phone"> Phone </label><br>
                            <input type="tel" name="phone" value="<?php echo $phone;?>">
                            <span> <?php echo $errors["phone"];?> </span>
                        </div>

                        <div>
                            <label> Password </label><br>
                            <input type="password" name="pwd" value="<?php echo $pwd;?>">
                            <span> *<?php echo $errors["pwd"];?> </span>
                        </div>
                        
                        <div>
                            <input type="submit" name="submit" value = "login" >
                        </div>

                        <div>
                            <span> <?php echo $errors["msg"];?> </span>
                        </div>

                        <p>Don't have an account? <a href="../register/register.php">register here</a>.</p><br>
                    
                </form>
            </div>
        </div>
    <?php include('../templates/footer.php'); ?>

</html>