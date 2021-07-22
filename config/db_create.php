<?php
   
   $servername="localhost";
   $username="Bode";
   $password="bode4376";
   // connect to database
   $conn= new mysqli($servername, $username, $password);
   //checking if connected to the database
   if($conn->connect_error){
       die("connection Failed: ". $conn->connect_error);
   }
   //creating a database
   $sql="CREATE DATABASE bobby_shoes";
   if($conn->query($sql) != true){
    echo "<br>Error creating database: ". $conn->error;
   }
   $conn->close();
?>