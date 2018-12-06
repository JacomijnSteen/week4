<?php

  // var_dump($_POST); die();

  //fouten melden!!
    error_reporting(1);
    ini_set('display_errors',1);

    include "openConn.php";

    $connection = new PDO($dsn, $user_name, $pass_word);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);     

  // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

 //bericht verwijderen
    $brweg = $_POST['id'];

    $rijweg= "DELETE FROM blogtext WHERE id='$brweg'";

    $result=$connection->query($rijweg);
      
      if($result>0){
       
          echo "bericht verwijderd";
      
      }else{

        echo "bericht niet verwijderd";
      }

    // Close connection
    mysqli_close($conn);

header('Location:blogtext.php');
?>