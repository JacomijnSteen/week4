<!DOCTYPE html>
<html>
  <head>
    <title> 1 textbericht </title>
    <!--<link rel="stylesheet" type="text/CSS" href="newtext.css"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

  <body>
      <?php
      include "openConn.php";
      $rowid = $_GET['id']; 
      try{
          $connection = new PDO($dsn, $user_name, $pass_word);
          $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);     

          $sql = "SELECT titel FROM blogtext WHERE id = '$rowid'";
          $titelOfText = $connection->query($sql);
          $titelResult = $titelOfText->fetch(PDO::FETCH_ASSOC);
           
          $oneTextSql = "SELECT bericht FROM blogtext WHERE id = '$rowid'";
          $result = $connection->query($oneTextSql);
          $textResult = $result->fetch(PDO::FETCH_ASSOC);  
      }
      catch(PDOException $e){
        echo "Error " . $e->getMessage();
      }                
      ?>
              <table>
                <tr>
                  <td>
                    <p>Titel: </p>   
                    <?php echo $titelResult['titel']; ?>
                  </td>
                </tr>
                <tr>
                  <td> 
                    <p>Bericht: </p>  
                    <?php  echo $textResult['bericht']; ?> 
                  </td>
                </tr>
                <tr>
                  <td>  
                    <button name = "terug" class= "NaarInvul" value = "$rowid" method = "POST" onclick = "terugNaarInvul()">edit</button>
                       <input type = "submit">
                          <script>
                              function terugNaarInvul() {
                                 
                                  location.replace("newtext.php");
                              }
                          </script>

                       
                       
                  </td> 
                </tr>
                <tr>
                  <td><h5>Vul hier eventuele opmerkingen in over bovenstaand bericht</h5>
                  </td>
                </tr>
                <tr>
                  <td>
                          
                    <form action="oneText.php" method="POST" class="comment">  
                      <textarea type = "text" cols="100" rows="1" name = "commentName" >Uw naam</textarea>
                           
                      <textarea type="text" cols="150" rows="10" name="comment">Plaats hier uw commentaar</textarea>
                        <input type = "submit" name= "submit">
                      </form>
                  </td>
                </tr>
              </table>    
                 <br/><br/><br/>
            
      <?php
      include "openConn.php";
        try{
            $connection = new PDO($dsn, $user_name, $pass_word);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);     

            $comment = $_POST['comment'];
            $comName = $_POST['commentName'];
            $commentInsertSql = "INSERT INTO comments (comment, name, titel) VAlUES ('$comment', '$comName' , '$titelResult')";
            $connection->exec($commentInsertSql);
      
            $last_id = $connection->lastInsertId();

            $insertBcSql = "INSERT INTO blogtext_comments (blogtext_id, comments_id) VALUES ('$rowid', '$last_id')";
            $connection->exec($insertBcSql);
   
            ?>
            <p><h5>Alle commentaren op dit artikel</h5></p> 
                    <table>
                        <tr>
                            <th>titel</th>
                            <th>commentaar</th>
                            <th>naam van schrijver van commentaar</th>
                        </tr>
            <?php

            $tableComments = "SELECT * FROM comments ";          
            $result = $connection->query($tableComments);
                foreach ($result as $row) {
                    ?>
                    
                        <tr>
                            <td> <?php echo $row['titel']; ?></td>
                            <td> <?php echo $row['comment']; ?></td>
                            <td> <?php echo $row['name']; ?></td>
                        </tr>
                    
                    </table>
                <?php
                }
        }
        catch(PDOException $e){
          echo "Error " . $e->getMessage();
        }   
        
      // Close connection
      $connection = null; 
      ?>
  </body>
  </html>