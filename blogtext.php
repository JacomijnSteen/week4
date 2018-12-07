<!DOCTYPE html>
<html>
    <head>    
        <title>blog</title>
      <!--  <link rel="stylesheet" type="text/CSS" href="blog.css">-->  
     
    </head>
<body>
    <?php
    include "openConn.php";
    
        $connection = new PDO($dsn, $user_name, $pass_word);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
  //Ik wil nu  alle berichten in een tabel laten zien 

    $sql4 = "SELECT b.id, b.datum, b.name, b.titel, GROUP_CONCAT(c.name) as category_name " .
        "FROM blogtext b " .
        "LEFT JOIN blogtext_categories bc ON b.id = bc.blogtext_id " .
        "LEFT JOIN categories c on bc.categories_id = c.id ";

    if (array_key_exists('categorie_select', $_GET) && isset($_GET['categorie_select'])) {
        $category_ids = implode(",", $_GET['categorie_select']);

        $sql4 .= "WHERE c.id = '$category_ids' ";
    }

    $sql4 .= "GROUP BY b.id " .
        "ORDER BY b.datum DESC";

    
    $result4 = $connection->query($sql4);


    ?>
        <div class="tabel">
            <table border='1px;'> 
                <tr>
                    <th><h4>datum</h4></th>
                    <th><h4>naam</h4></th>
                    <th><h4>titel</h4></th>
                    <th><h4>categorie</h4></th>
                    <th></th>
                </tr>

                <?php 
                if (!empty($result4)) {                
                    foreach ($result4 as $row){
                        
                ?>
                <tr>    
                    <td><?php echo $row['datum']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><a href = 'oneText.php?id=<?php echo $row["id"] ?>' alt='oneText'> <?php echo $row["titel"]; ?></a></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td>
                        <form action="blog.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>"/> 
                            <input type="submit" value="verwijderen" name="submit"/>
                        </form>
                    </td>
                </tr>
                               
            <?php
                   } 
                }
            ?>
            </table>
            
        </div>       
    <?php               
  
 // Close connection
    $connection = null;
     ?>

      <!--nieuw artikel toevoegen door naar de site met invulform te gaan-->
        <div>
                <br/>
            <a href="newtext.php"><h3>Voeg een nieuw bericht of artikel toe</h3></a> 
                <br/><br/>
        </div>  
  
<!-- Hier begint het gedeelte van het opvragen van teksten geselecteerde op gewenste categorien-->

        <div>
            <p class="categorie_select"><h3>selecteer de artikelen op thema</h3></p>
        </div>

<!--Ik wil nu de blogtexten selecteren op thema's . Eerst de  id van de geselecteerde opties opvragen $category_ids.-->
        <?php
        include "openConn.php";
        try {
            $connection = new PDO($dsn, $user_name, $pass_word);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
            $selectCategorieSql = "SELECT * FROM categories ORDER BY id ASC";
            $result = $connection->query($selectCategorieSql);
        ?>
        <form action="blogtext.php" method="GET">
        <?php
            foreach ($result as $row) {
            
            ?>
             <input type="checkbox"  name="categorie_select[]" value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?><br/>
            <?php   
            }    
        }
        catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }      
        ?>
         <input type="submit"  name="selecteer"  value="selecteer"> 
        </form>

<!-- Een nieuwe categorie toevoegen-->
        <div>
            <br/>
        <form  method ="POST" action="blogtext.php" >
            <h3> Voeg een nieuwe categorie voor uw texten toe: </h3>
            <input type = "text" name = "newCat">
            <input type = "submit" name = "verzenden">
        </form>
            <br/>
        <?php
    //nieuwe categorie toevoegen
        
        include "openConn.php" ;
        if(!empty($_POST ['newCat'])){
            try {
                $connection = new PDO($dsn, $user_name, $pass_word);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                $insertCategorie=$_POST['newCat'];
                $insertCategorieSql = "INSERT INTO categories (name)
                                        VALUES ('$insertCategorie')";
         
                $result = $connection->exec($insertCategorieSql);
              
            }
            catch(PDOException $e) {
                echo $insertCategorieSql . "<br>" . $e->getMessage();
            }   
        }
        // Close connection
            $connection = null;  
        ?>  
    </div>


    <!--invoeren van een zoekterm-->
    <div class="zoek"><br/>

        <form  method ="POST" action="blogtext.php" >
            <h3> Zoek op trefwoorden: </h3>
            <input type = "text" name = "zoekterm">
            <input type = "submit" name = "verzenden">
        </form>
            <br/>

        <?php
        include "openConn.php";
        if(!empty($_POST ['zoekterm'])){
            try {
                $connection = new PDO($dsn, $user_name, $pass_word);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $zoekterm=$_POST['zoekterm'];
                
                $zoekSql = "SELECT * FROM blogtext WHERE titel LIKE '%$zoekterm%'";

                $result = $connection->query($zoekSql);
                if($result === 0){
                    $err = $connection->errorInfo();
                    print_r($err);
                }         
        ?>

                <div class="tabel">
                    <table border='1px;'> 
                        <tr>
                        <th><h4>datum</h4></th>
                            <th><h4>naam</h4></th>
                            <th><h4>titel</h4></th>
                            <th><h4>bericht</h4></th>
                          
                            <th></th>
                        </tr>
                        <?php
                                      
                            foreach($result as $row){
                            ?>

                            <tr>    
                                <td><?php echo $row['datum'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['titel'] ?></td>
                                <td><?php echo $row['bericht'] ?></td>
                                
                                <td><form action="blog.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $row['id'] ?>"/> 
                                    <input type="submit" value="verwijderen" name="submit"/></form>
                                </td>
                            </tr>
                                
                            <?php
                            } 
                        
            }
            catch(PDOException $e) {
                    echo $sql . "<br>" . $e->getMessage();
            } 
        }
                            ?>          
                    </table>
      
                </div> 
</body>
</html>
