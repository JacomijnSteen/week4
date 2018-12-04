<!DOCTYPE html>
<html>
  <head>
    <title>nieuwe tekst invoeren in blog met database </title>
   <!-- <link rel="stylesheet" type="text/CSS" href="blog.css"> -->
  </head>

  <body>
    <?php
//fouten melden!!
  error_reporting(1);
  ini_set('display_errors',1);
   ?>
    
    <section>
        <br/><br/><br/>
        <form action="newtext.php" method="POST" class="inputtext">
          <input type="text" name="fname" placeholder="voornaam">
                <br/><br/><br/>
          <input type="text" name="lname" placeholder="achternaam">
                <br/><br/><br/>
          <input type="text" name="titel" placeholder="titel">
                <br/><br/><br/>
         
        bericht<br/>
        <textarea type="text" cols="100" rows="20" name="blogbericht"></textarea>
                 <br/>

        <p class="categorie">categorie waaronder dit artikel of bericht valt</p>

        <?php
    //bij opslaan van artikel  moet ik voor de keuze van de categorie de id van betreffende categorie toevoegen.
               
    include "openConn.php";
        
    try {
      $connection = new PDO($dsn, $user_name, $pass_word);
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
        $sql = "SELECT * FROM categories ORDER BY id ASC";

        $result = $connection->query($sql);
        
    
        ?>

        <form action="newtext.php" method ="POST" >
          <select name="catkeuze" class="catkeuze">  
         <?php
          foreach ($result as $row) {
         ?>
       
            <option value="<?php echo $row['id']; ?>" > <?php echo $row['name']; ?> </option>
       
         <?php
            }    
          
    }
    catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }   
         ?>
          </select>
             <input type="submit" name="submit" value="Toevoegen"> 
        </form>
    </section>
    <?php
    // Close connection
    $connection = null; 
  
    
 
   //checken of velden ingevuld zijn.
      $fname=$_POST['fname'];
      $lname=$_POST['lname'];
      $titel=$_POST['titel'];
      $datum=$_POST['date'];
      $bericht=$_POST['blogbericht'];

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

   //nieuwe text opslaan in db met aangevinkte categorie keuze erbij
   include "openConn.php";
   try {
    $connection = new PDO($dsn, $user_name, $pass_word);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);     

      $categorieId = $_POST['catkeuze'];

      $sql1 = "INSERT INTO blogtext (fname, lname, titel, datum, bericht, category_id) 
              VALUES ('$fname', '$lname', '$titel', NOW() , '$bericht', '$categorieId')";
           
      $result = $connection->exec($sql1);
      
      if($result === 0){
         $err = $connection->errorInfo();
         print_r($err);
      }  
       
        echo $continent . "Je bericht is opgeslagen";    
    }
    catch(PDOException $e) {
        echo $sql1 . "<br>" . $e->getMessage();
    }
            
    // Close connection
    $connection = null; 

       // header('Location:blogtext.php');
    ?>
  </body>
</html>