<?php

  //heb ik de post value?
  //zo ja, voeg dan een where aan de query toe





  //fouten melden!!
    error_reporting(1);
    ini_set('display_errors',1);

  //  connectie maken    
    $db = "blog";
    $host = "localhost";
    $dsn = "mysql:dbname=$db;host=$localhost";
    $user_name = "root";
    $pass_word = "";  

  //variabelen definieren
  //geplaatst bericht
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $titel=$_POST['titel'];
    $bericht=$_POST['blogbericht'];

    $catkeuze=$_POST['catkeuze'];
      
  //checken of velden ingevuld zijn.
  if(empty($fname) || empty($lname) || empty($titel) || empty($bericht)){
    
    echo "naam, titel of bericht is niet ingevuld";
  }

  //de velden naam email en bericht bewapenen tegen hackers inputs
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = schoonmaken($_POST['fname']);
    $lname = schoonmaken($_POST['lname']);
    $titel = schoonmaken($_POST['titel']);
    $bericht = schoonmaken($_POST['blogbericht']);    
  }

  function schoonmaken($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  //nieuwe text opslaan met aangevinkte categorie keuze erbij
 
  $connection = new PDO($dsn, $user_name, $pass_word);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    try {       
      $categorieId = $_POST['catkeuze'];

      $sql = "INSERT INTO blogtext (fname, lname, titel, datum, bericht, category_id) 
              VALUES ('$fname', '$lname', '$titel', NOW() , '$bericht', '$categorieId')";
 
      
      $connection->exec($sql);         
    }
    catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }    
  
  echo "Je bericht is opgeslagen";
  
     
  //bericht verwijderen
    $brweg = $_POST['id'];

    try {
      $connection = new PDO($dsn, $user_name, $pass_word);
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $rijweg= "DELETE FROM blogtext WHERE id=$brweg";
 
      $connection->exec($rijweg);
    }  
    catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }    
 
    // Close connection
$connection = null; 

header('Location:blogtext.php');
?>