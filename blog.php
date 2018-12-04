<?php

  //fouten melden!!
    error_reporting(1);
    ini_set('display_errors',1);

include "createConn.php";

       
     
  //bericht verwijderen
    $brweg = $_POST['id'];

    $rijweg= "DELETE FROM blogtext WHERE id=$brweg";
      
    $result=mysqli_conn($conn,$rijweg) 
      
      if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)) {
          echo "bericht verwijderd";
        }
      }else{
        echo "bericht niet verwijderd";
      }

    // Close connection
    mysqli_close($conn);

header('Location:blogtext.php');
?>