<?php
include("validate_reg.php");

?>
<!DOCTYPE html>
<html>

<head>
    <title>register</title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style type="text/css">
        form {
            max-width: 460px;
            margin: 20px auto;
            padding: 20px;
            background: white;
        }

        span {
            color: red;
        }
    </style>
</head>

<body class="grey lighten-4">

    <div>
        <div class="container">
            <h2>Sign Up</h2>
            <p>Please fill this form to create an account.</p>
        </div>

        <div class="container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                
                    <div>
                        <label for="firstName"> Name</label><br>
                        <input type="text" name="firstName" value="<?php echo $firstName;?>">
                        <span>* <?php echo $errors["firstName"] ?></span>
                    </div>

                    <div>
                        <label for="lastName"> Last name </label><br>
                        <input type="text" name="lastName" value="<?php echo $lastName;?>" >
                        <span>* <?php echo $errors["lastName"] ?></span>
                    </div>

                    <div>
                        <label for="phone"> Phone </label><br>
                        <input type="tel" name="phone"value="<?php echo $phone;?>">
                        <span>* <?php echo $errors["phone"] ?></span>
                    </div>

                    <div>
                        <label for="email"> Email </label><br>
                        <input type="email" name="email" value="<?php echo $email;?>">
                        <span>* <?php echo $errors["email"] ?></span>
                    </div>


                    <div>
                        <label> Password </label><br>
                        <input type="password" name="pwd" value="<?php echo $pwd;?>">
                        <span>* <?php echo $errors["pwd"] ?></span>
                    </div>

                    <div>
                        <label> Confirm Password </label><br>
                        <input type="password" name="cpwd" value="<?php echo $cPwd;?>">
                        <span>* <?php echo $errors["cPwd"] ?></span>
                    </div>

                    <div>
                        <input type="submit" name="submit" value="register">
                    </div>

                    <div>
                        <span> <?php echo $errors["msg"]; ?> </span>
                    </div>

                    <p>Already have an account? <a href="../login/login.php">Login here</a>.</p><br>
                
            </form>
        </div>
    </div>
</body>

</html>