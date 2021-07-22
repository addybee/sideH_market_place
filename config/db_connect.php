<?php 

	// connect to the database
    $servername="localhost";
    $username="Bode";
    $password="bode4376";
    $db = "bobby_store";
    // connect to database
    $conn= new mysqli($servername, $username, $password, $db);

	// check connection
	if($conn->connect_error){
		echo 'Connection error: '. $conn->connect_error;
	}

?>