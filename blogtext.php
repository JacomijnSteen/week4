<!DOCTYPEhtml>
<html>
    <head>    
        <title>week3 blog</title>
      <!--  <link rel="stylesheet" type="text/CSS" href="blog.css">-->  
    </head>
    <body>
    <?php

    //database opzoeken en verbinden 
    $db="blog";
    $host = "localhost";
    $dsn = "mysql:dbname=$db;host=$host";
    $user_name = "root";
    $pass_word ="";

    try {
        $connection = new PDO($dsn, $user_name, $pass_word);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    //Ik wil nu table bekijken
        $sql = "SELECT * FROM blogtext ORDER BY datum DESC";

        $statement = $connection->prepare($sql);

        $statement->bindParam(":fname", $fname);
        $statement->bindParam(":lname", $lname);
        $statement->bindParam(":datum", $datum);
        $statement->bindParam(":titel", $titel);
        $statement->bindParam(":bericht", $bericht);

        if ($statement->execute()) { 
            
            ?>cd 
        <div class="tabel">
            <table border='1px;'> 
                <thead>
                <tr>
                    <th><h4>naam</h4></th>
                    <th><h4>titel</h4></th>
                    <th><h4>datum</h4></th>
                    <th><h4>bericht</h4></th>
                    <th><h4>categorie</h4></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
            while ($row =  $statement->fetch()) {
                ?>
                
                <tr>    
                    <td><?php echo $row['fname'] . $row['lname']?></td>
                    <td><?php echo $row['titel'] ?></td>
                    <td><?php echo $row['datum']?></td>
                    <td><?php echo $row['bericht'] ?></td>
                    <td><?php echo $row['category_id']?></td>
                    <td><form action="blog.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>"/> 
                        <input type="submit" value="verwijderen" name="submit"/></form>
                    </td>
                </tr>
                               
            <?php
            } 
            ?>
            </tbody>
            </table>
        </div>       
            <?php
        }else {
                echo "query niet uitgevoerd";
        } 
        
        ?>


<!--nieuw artikel toevoegen door naar de site met form te gaan-->
        <div>
                <br/>
            <a href="newtext.php"  class ="newtext.php" >Voeg een nieuw bericht of artikel toe</a> 
        </div>  


            <div>
            <p class="bepcatopvr"><h3>selecteer de artikelen op thema</h3></p>
            </div>
<!--Ik wil nu de blogtexten selecteren op thema . Eeerst de  id van de geselecteerde opties opvragen.-->
        <?php
        $sql3 = "SELECT * FROM categories ORDER BY id ASC";

        $statement = $connection->prepare($sql3);

        $statement->bindParam(":id", $row['id']);
        $statement->bindParam(":name", $row['name']);

        ?>
        <form method="POST" action="blogtext.php">
        <select multiple name="bepcatopvr" class="bepcatopvr">  
        <?php
       
        if ($statement->execute()) { 
            while ($row =  $statement->fetch()) {
                
         ?>              
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
        <?php
            }    
        }else {
            echo "0 results";
        }
        ?>
        </select>
            <input type="submit" name="submit" value="selecteer"> 
        </form>
        <?php 

//Ik wil nu de table bekijken geselecteerd op 1 catagorie. categorie hierboven geselecteerd
         $catid=$_POST['bepcatopvr'];

      
        
         //Ik wil nu de uitgedunde table bekijken
        $sql2 = "SELECT * FROM blogtext WHERE category_id=:category ORDER BY datum DESC";
 
        $statement = $connection->prepare($sql2);
        $statement->bindParam(':category', $catid);

        if ($statement->execute()) { 
            
            ?>
        <div class="tabel">
            <table border='1px;'> 
                <thead>
                <tr>
                    <th><h4>naam</h4></th>
                    <th><h4>titel</h4></th>
                    <th><h4>datum</h4></th>
                    <th><h4>bericht</h4></th>
                    <th><h4>categorie</h4></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
            while ($row =  $statement->fetch()) {
                ?>
                
                <tr>    
                    <td><?php echo $row['fname'] . $row['lname']?></td>
                    <td><?php echo $row['titel'] ?></td>
                    <td><?php echo $row['datum']?></td>
                    <td><?php echo $row['bericht'] ?></td>
                    <td><?php echo $row['category_id']?></td>
                    <td><form action="blog.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>"/> 
                        <input type="submit" value="verwijderen" name="submit"/></form>
                    </td>
                </tr>
                               
            <?php
            } 
            ?>
            </tbody>
            </table>
        </div>       
            <?php
        }else {
                echo "query niet uitgevoerd";
        } 
        
    }

    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }   
    ?>

        

        <?php
    // Close connection
            $connection = null; 
        ?>
    </body>
</html>