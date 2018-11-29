<!DOCTYPE html>
<html>
  <head>
    <title>nieuwe tekst invoeren in blog met database </title>
   <!-- <link rel="stylesheet" type="text/CSS" href="blog.css"> -->
  </head>

  <body>
    <section>
        <br/><br/><br/>
        <form action="blog.php" method="POST" class="inputtext">
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
    //bij opslaan van artikel  moet ik de id van betreffende categorie toevoegen.
        $dbname = "blog";
        $servername = "localhost";
        $username = "root";
        $password ="";

       
    // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM categories ORDER BY id ASC";

        $result = mysqli_query($conn, $sql);

        $resultCheck = mysqli_num_rows($result);
        ?>
        <select multiple name="catkeuze" class="catkeuze">  
        <?php
        if ($resultCheck > 0){
            while($row = $result->fetch_assoc()){
       
        ?>
            <option value="<?php echo $row['id']; ?>" > <?php echo $row['name']; ?> </option>
        <?php
            }    
        }else {
            echo "0 results";
        }
        ?>
        </select>
        
            <input type="submit" name="submit" value="Toevoegen"> 
        </form>
    </section>
    <?php
    
    // Close connection
        $connection = null; 

        //header('Location:blogtext.php');
    ?>
  </body>
</html>
