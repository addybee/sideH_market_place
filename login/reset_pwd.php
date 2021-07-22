<?php
session_start();

if (!$_SESSION["loggedin"]) {
    header("location:login.php");
    exit();
}
$npwd = $id= $cpwd = "";
$errors = array('npwd' => "", 'cpwd' => "", 'msg' => "");
include("../config/db_connect.php");
if(isset($_POST["submit"])){
    
    // Check if current password is empty
    if(empty($_POST["cpwd"])){
        $errors["cpwd"] = "Please enter your current password.";
    } else{
        $cpwd = test_ip($_POST["cpwd"]);
    }
    
    // Check if new password is empty
    if(empty($_POST["npwd"])){
        $errors["npwd"] = "Please enter your new password.";
    } else{
        $npwd = test_ip($_POST["npwd"]);
        if (strlen($npwd) < 8) {
            $errors["npwd"] = "Your password Must Contain At Least 8 Characters!";
        } elseif (!preg_match("#[0-9]+#", $npwd)) {
            $errors["npwd"] = "Your password Must Contain At Least 1 Number!";
        } elseif (!preg_match("#[A-Z]+#", $npwd)) {
            $errors["npwd"] = "Your password Must Contain At Least 1 Capital Letter!";
        } elseif (!preg_match("#[a-z]+#", $npwd)) {
            $errors["npwd"] = "Your password Must Contain At Least 1 Lowercase Letter!";
        }
    }
    
    // Validate credentials
    if(!array_filter($errors)){
            
        $cpwd = $conn->real_escape_string($cpwd);
        $npwd = $conn->real_escape_string(password_hash($npwd, PASSWORD_DEFAULT));
        $id = $conn->real_escape_string($_POST['id']);
        
        $sql = "SELECT * from users WHERE id = '$id'";
        $result = $conn->query($sql);
        //$conn->close();
        if($result->num_rows<1){
            $errors["msg"] = "invalid user";
        }else{
            $row = $result->fetch_assoc();
            
            if(password_verify($cpwd, $row["password"])){
                
                $sql = "UPDATE users SET password = '$npwd' WHERE id = '$id'";
                
                if($conn->query($sql)!==TRUE){
                   $errors['msg']= $conn->error;
                    
                }
                //redirect to home page
                $loginP="location:../index.php";
                header($loginP);
            }
            
        }
    }
}

?>
<!DOCTYPE html>
<html>

    <head>
        <title>Reset password</title>
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

                    <li><a href="../items/add_item.php" class="btn brand z-depth-0">Add item</a></li>
                    <li><a href="reset_pwd.php" class="btn brand z-depth-0">reset password</a></li>
                    <li><a href="#" class="btn brand z-depth-0">contact</a></li>

                </ul>
            </div>
        </nav>

        <!-- form input -->
        <div class="container">
            <div class="container">
                <h2>Reset password</h2>
                <p>Please fill this form below to account password.</p>
            </div>

            <div class="container">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    
                <input type="hidden" name = "id" value= "<?php echo $_SESSION['id'];?>">

                    <div>
                        <label for="phone"> current password </label><br>
                        <input type="password" name="cpwd" value="<?php echo $cpwd; ?>">
                        <span> <?php echo $errors["cpwd"]; ?> </span>
                    </div>

                    <div>
                        <label> new Password </label><br>
                        <input type="password" name="npwd" value="<?php echo $npwd; ?>">
                        <span> *<?php echo $errors["npwd"]; ?> </span>
                    </div>

                    <div>
                        <input type="submit" name="submit" value="change">
                    </div>

                    <div>
                        <span> <?php echo $errors["msg"]; ?> </span>
                    </div>

                </form>
            </div>
        </div>
    <?php include('../templates/footer.php'); ?>

</html>
<?Php
//this function trims, strip slashes and and convert data to special html characters
    function test_ip($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    } ?>