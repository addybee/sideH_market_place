<?php
    require("db_connect.php");
    // create a  table sql query
    $sql="CREATE TABLE IF NOT EXISTS users(
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        phone VARCHAR(11) NOT NULL UNIQUE,
        email VARCHAR(50) NOT NULL, 
        password VARCHAR(255) NOT NULL)";

        $sql1 ="CREATE TABLE IF NOT EXISTS product(
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            users_id int(6) unsigned NOT NULL,
            item VARCHAR(255) NOT NULL,
            price VARCHAR(11) NOT NULL,
            posted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
            FOREIGN KEY (users_id) REFERENCES users(id))";
    //testing executed query
    if($conn->query($sql1)===true){
        echo "<br>table successfully created"; 
    }else{
        echo "<br>Error creating table: ". $conn->error;
    }
    $conn->close();
?>