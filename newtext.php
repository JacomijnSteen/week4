<!DOCTYPE html>
<html>
  <head>
    <title>nieuwe tekst invoeren in blog database </title>
    <link rel="stylesheet" type="text/CSS" href="newtext.css"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

  <body>
    <div class = "bovenregel">
      <p><h2>Plaats hier een nieuw bericht op mijn blog</h2></p>
    </div>  
    
        <br/>
    <form action="newtext.php" method="POST" class="inputtext">
       <input type="text" name="name" placeholder="naam">
                <br/><br/><br/>
        <input type="text" name="titel" placeholder="titel">
                <br/><br/><br/>
         
        bericht<br/>
        <textarea type="text" cols="150" rows="10" name="blogbericht"></textarea>
                 <br/>

        <p class="categorieNewText"><h3>selecteer een categorie waaronder dit artikel of bericht valt</h3></p>

        <?php

//bij opslaan van artikel  checkbox weergeven met categorien waar het artikel over gaat

    include "openConn.php";
        
    try {
      $connection = new PDO($dsn, $user_name, $pass_word);
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
        $sql = "SELECT * FROM categories ORDER BY id ASC";

        $result = $connection->query($sql);
            
        ?>
        <form action="newtext.php" method ="POST" class = "checkbox">
          <?php
            foreach ($result as $row) {
          ?>
           <input type="checkbox"  name="catkeuze[]"  value="<?php echo $row['id'] ?>"><span class="color-white"><?php echo $row['name'] ?></span><br/>
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
  
 //checken of velden ingevuld zijn.
      $name=$_POST['name'];
      $titel=$_POST['titel'];
      $bericht=$_POST['blogbericht'];
  
      if(empty($name) || empty($titel) || empty($bericht)){     
        echo "naam, titel of bericht is niet ingevuld.";
      }
 
   //de velden naam email en bericht bewapenen tegen hackers inputs
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = schoonmaken($_POST['name']);
        $titel = schoonmaken($_POST['titel']);
        $bericht = schoonmaken($_POST['blogbericht']);    
      }
 
      function schoonmaken($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

//nieuwe text opslaan in db en de nieuwe id hiervan opvragen (=$resultId)   

      $sql1 = "INSERT INTO blogtext (titel , datum , bericht , name) VALUES ('$titel' , NOW() , '$bericht' , '$name');";
              
      $result = $connection->exec($sql1);
      
      if($result === 0){
        $err = $connection->errorInfo();
        print_r($err);
      }  

       $resultId = $connection->lastInsertId();
      
      if($result === 0){
          $err = $connection->errorInfo();
          print_r($err);
      }
     
//in de tabel blogtext_categories opslaan het id van de nieuwe tekst met elke id van de gekozen categorien (=$catkeuze)

      if (array_key_exists('catkeuze', $_POST) && count($_POST['catkeuze']) > 0) {
        foreach ($_POST['catkeuze'] as $categorieId) {
          $catKeuzeInvoerSql = "INSERT INTO blogtext_categories (blogtext_id, categories_id)
                                  VALUES ($resultId, $categorieId)";
          $result = $connection->exec($catKeuzeInvoerSql);
        }  
      }

      if(isset($_POST['blogbericht'])) {
        header('Location:blogtext.php');
      }
    
// Close connection
    $connection = null; 
    ?>
  </body>
</html>