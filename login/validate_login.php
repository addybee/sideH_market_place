<?php
    $phone = $pwd = "";
    $errors = array('pwd'=>"", 'phone'=>"", 'msg'=>"");
    session_start();
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        // Check if phone is empty
        if(empty($_POST["phone"])){
            $errors["phone"] = "Please enter phone.";
        } else{
            $phone = test_ip($_POST["phone"]);
        }
        
        // Check if password is empty
        if(empty($_POST["pwd"])){
            $errors["pwd"] = "Please enter your password.";
        } else{
            $pwd = test_ip($_POST["pwd"]);
        }

        // Validate credentials
        if(!array_filter($errors)){
            
            include("../config/db_connect.php");
            $phone = $conn->real_escape_string($phone);

            $sql = "SELECT * from users WHERE phone = '$phone'";
            $result = $conn->query($sql);
            //$conn->close();
            if($result->num_rows<1){
                $errors["msg"] = "invalid phone or password";
            }else{
                $row = $result->fetch_assoc();
                
                if(password_verify($pwd, $row["password"])){
                    $_SESSION['loggedin']=TRUE;
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['first_name']=$row['first_name'];
                    $loginP="location:../index.php";
                    header($loginP);
                                        
                }else{
                    $errors["msg"] = "invalid phone or password";
                }
            }
        }
    }

    //this function trims, strip slashes and and convert data to special html characters
    function test_ip($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
