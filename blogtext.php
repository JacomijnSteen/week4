<!DOCTYPEhtml>
<html>
    <head>    
        <title>week3 blog</title>
      <!--  <link rel="stylesheet" type="text/CSS" href="blog.css">-->  
     
    </head>
<body>
    <?php

    include "openConn.php";
    
        $connection = new PDO($dsn, $user_name, $pass_word);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
 //Ik wil nu  alle berichten in een tabel laten zien
        $blogTextSql = "SELECT * FROM blogtext ORDER BY datum DESC";

        $result = $connection->query($blogTextSql);
      
    if($result === 0) {
        $err = $connection->errorInfo();
        print_r($err);
      } 

    ?>
        <div class="tabel">
            <table border='1px;'> 
                <tr>
                    <th><h4>naam</h4></th>
                    <th><h4>titel</h4></th>
                    <th><h4>datum</h4></th>
                    <th><h4>bericht</h4></th>
                    <th><h4>categorie</h4></th>
                    <th></th>
                </tr>

                <?php 
                if (!empty($result)) {                
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
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
            <a href="newtext.php"  class ="newtext.php" ><h3>Voeg een nieuw bericht of artikel toe</h3></a> 
                <br/><br/>
        </div>  
  
<!-- Hier begint het gedeelte van het opvragen van teksten geselecteerde op gewenste categorien-->

        <div>
            <p class="categorie_select"><h3>selecteer de artikelen op thema</h3></p>
        </div>

<!--Ik wil nu de blogtexten selecteren op thema's . Eerst de  id van de geselecteerde opties opvragen.-->
        <?php
        include "openConn.php";

        try {
            $connection = new PDO($dsn, $user_name, $pass_word);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  

            $selectCategorieSql = "SELECT * FROM categories ORDER BY id ASC";
            $result = $connection->query($selectCategorieSql);
        ?>
        <form action="blogtext.php" method="POST" >
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
       
        
           

    <!--Ik wil nu uit de table de geselecteerde categorien opvragen-->
    <?php 
    //optie 1
        // if (!empty($_POST['categorie_select'])){

        //     $categorieSelect= array();

        //     array_push($categorieSelect,echo $row['id']);

        
        //     for($i=0; $i<count($categorieSelect); $i++) {
        //         foreach ($x as echo $row['id']){
            
    //optie2
        if (!empty($_POST['categorie_select'])){
            $category_ids= implode (",", $_POST['categorie_select']);

            //Ik wil nu de uitgedunde table bekijken
            include "openConn.php";
            
                try {
                    $connection = new PDO($dsn, $user_name, $pass_word);
                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $categorieTextSql = "SELECT * FROM blogtext
                                            WHERE category_id
                                            IN($category_ids)";                                     
                                            
                                          
                   
                    $result = $connection->query($categorieTextSql);

                    if($result === 0){
                        $err = $connection->errorInfo();
                        print_r($err);
                    } 
            
                    ?>
                    <br/><br/><br/>
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
                    if ($result > 0) {                
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
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
                    <?php
                    }else {
                        echo "query niet uitgevoerd";
                    } 
                 ?>
                    </table>
                </div>       
                <?php
                }
                catch(PDOException $e) {
                    echo $sql . "<br>" . $e->getMessage();
                }
        }
  
    // Close connection
    $connection = null;  
            ?>  

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



    </body>
</html>