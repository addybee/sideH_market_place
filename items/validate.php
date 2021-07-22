<?php
    include('../config/db_connect.php');

	$item = $price= '';
	$errors = array('item' => '', 'price' => '', 'msg'=> '');

	if($_SERVER["REQUEST_METHOD"]=='POST'){

		// check item
		if(empty($_POST['item'])){
			$errors['item'] = 'A item is required';
		} else{
			$item = test_ip($_POST['item']);
			if(!preg_match('/^[a-zA-Z\d\s]+$/', $item)){
				$errors['item'] = 'item must be letters, number and spaces only';
			}
		}

		// check price
		if(empty($_POST['price'])){
			$errors['price'] = 'price is required';
		} else{
			$price = test_ip($_POST['price']);
            
			if(!preg_match("/^(#)\d{1,3}(\,\d{3})*(\.\d+)?$/", $price)){
                $errors['price']="invalid price";
            }
		}

		if(!array_filter($errors)){
		 	
            $item = $conn->real_escape_string($item);
            $price = $conn->real_escape_string($price);
            $userId = $conn->real_escape_string($_SESSION["id"]);
            
            //check if phone already exist
            $sql= "SELECT* FROM product WHERE item= '$item' AND users_id= '$userId'";
            $result = $conn->query($sql);
            if($result->num_rows>0){
                //already exist
                $errors["msg"] = "already posted item";
                
            }else{
                //insert into database
                $sql= "INSERT INTO product(users_id, item, price)
                VALUES('$userId', '$item', '$price')";
                if($conn->query($sql)!==TRUE){
                    $errors["msg"]= $conn->error;
                }
                header("location:../index.php?logged=true");
            }
    
        } else {
            $errors["msg"] = "Oops! Something went wrong. Please try again later.";
        }

	} // end POST check

    //this function trims, strip slashes and and convert data to special html characters
    function test_ip($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>