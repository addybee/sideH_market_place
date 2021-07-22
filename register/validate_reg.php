<?php
session_start();
$firstName = $lastName = $phone = $email = $pwd = $submit = $cPwd = $msg = "";
$errors = array('firstName' => "", 'lastName' => "", 'phone' => "", 'email' => "", 'pwd' => "", 'cPwd' => "", 'msg' => "");
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    //validate first name
    if (empty($_POST["firstName"])) {
        $errors["firstName"] = "first name required!";
    } else {
        $firstName = test_ip($_POST["firstName"]);
        if (!preg_match("/^[a-zA-Z\s]+$/", $firstName)) {
            $errors["firstName"] = "only letter and white space are allowed! ";
        }
    }
    //validate last name
    if (empty($_POST["lastName"])) {
        $errors["lastName"] = "last name required!";
    } else {
        $lastName = test_ip($_POST["lastName"]);
        if (!preg_match("/^[a-zA-Z\s]+$/", $lastName)) {
            $errors["lastName"] = "only letter and white space are allowed! ";
        }
    }
    //validate phone number
    if (empty($_POST["phone"])) {
        $errors["phone"] = "phone required!";
    } else {
        $phone = test_ip($_POST["phone"]);
        if (!preg_match("/^((\d){11})$/", $phone)) {
            $errors["phone"] = "invalid phone number!";
        }
    }
    //validate email
    if (empty($_POST["email"])) {
        $errors["email"] = "email is required!";
    } else {
        $email = test_ip($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "invalid email format!";
        }
    }
    
    //validate password
    if (empty($_POST["pwd"])) {
        $errors["pwd"] = "enter password!";
    } else {
        $pwd = test_ip($_POST["pwd"]);
        if (strlen($pwd) < 8) {
            $errors["pwd"] = "Your password Must Contain At Least 8 Characters!";
        } elseif (!preg_match("#[0-9]+#", $pwd)) {
            $errors["pwd"] = "Your password Must Contain At Least 1 Number!";
        } elseif (!preg_match("#[A-Z]+#", $pwd)) {
            $errors["pwd"] = "Your password Must Contain At Least 1 Capital Letter!";
        } elseif (!preg_match("#[a-z]+#", $pwd)) {
            $errors["pwd"] = "Your password Must Contain At Least 1 Lowercase Letter!";
        }
    }
    //validate confirm password
    if (empty($_POST["cpwd"])) {
        $errors["cPwd"] = "confirm password";
    } else {
        $cPwd = test_ip($_POST["cpwd"]);
        if (empty($errors["pwd"]) && ($pwd != $cPwd)) {
            $errors["cPwd"] = "Password did not match.";
        }
    }
    
    if (!array_filter($errors)) {
        include("../config/db_connect.php");
        
        $firstName = $conn->real_escape_string($firstName);
        $lastName=$conn->real_escape_string($lastName);
        $phone = $conn->real_escape_string($phone);
        $email = $conn->real_escape_string($email);
        $pwd =$conn->real_escape_string(password_hash($pwd, PASSWORD_DEFAULT));
        //check if phone already exist
        $sql= "SELECT* FROM users WHERE phone= '$phone'";
        $result = $conn->query($sql);
        if($result->num_rows>0){
            //already exist
            $errors["msg"] = "already registered with phone number";
            
        }else{
            //insert into database
            $sql= "INSERT INTO users(first_name, last_name, phone, email, password)
            VALUES('$firstName', '$lastName', '$phone', '$email','$pwd')";
            if($conn->query($sql)!==TRUE){
                $errors["msg"]= $conn->error;
            }
            header("location:../login/login.php");
        }

    } else {
        $errors["msg"] = "Oops! Something went wrong. Please try again later.";
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
