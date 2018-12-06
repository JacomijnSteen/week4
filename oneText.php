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
      $connection = new PDO($dsn, $user_name, $pass_word);
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);     
  
    
        $rowid = $_GET['id'];
        $oneTextSql = "SELECT bericht FROM blogtext WHERE id='$rowid'";

        $result = $connection->query($oneTextSql);
                 print_r($result);
        ?>
  </body>
  </html>