<?php

    //MySQLi connect to database
   $conn = mysqli_connect('localhost', 'root', '', 'pizza_mozarella');

   //check connection
   if(!$conn){
    echo 'Connection error: '. mysqli_connect_error(); //display error
   }



?>