<!DOCTYPEhtml>
<html>
    <head>    
        <title>inlog- en registratie pagina</title>
      <!--  <link rel="stylesheet" type="text/CSS" href="blog.css">-->  
     
    </head>
<body>

<section class="registreren">
        <p><h3>Hier kunt u registreren</h3></p>
        <br/><br/><br/>
      <form action = "inlogpag.php" method = "POST">
        <input type = "text" name = "name" placeholder = "naam">
                <br/><br/><br/>
        <input type = "email" name = "email" placeholder = "email">
                <br/><br/><br/>
        <input type = "password" name = "password1" placeholder = "password">
                <br/><br/><br/>
        <input type = "password" name = "password2" placeholder = "herhaal uw password">
                <br/><br/><br/>   
            <input type="submit" name="registreer" value="Verzenden">
                <br/><br/><br/>
      </form>
</section>

<section class="inloggen">
        <p><h3>Log in</h3></p>
                <br/><br/><br/>
      <form action = "inlogpag.php" method = "POST">
        <input type = "email" name = "inlogEmail" placeholder = "email">
                <br/><br/><br/>
        <input type = "password" name = "inlogPassword" placeholder = "password">
                <br/><br/><br/>
            <input type="submit" name="logIn" value="Log in">
                <br/><br/><br/>
      </form>
</section>

<!-- bij een nieuwe registratie krijg ik een mail wie zich heeft geregistreerd, diegene krijgt een mail met "welkom"-->
    <?php
        // $name = $_POST['name']; 
        // $email = $_POST['email'];
        // $password1 = $_POST['password1'];
        // $password2 = $_POST['password2'];

        // $email_from = 'jacomijnsteen@gmail.com';
        // $email_subject = "nieuwe registratie in blog";
        // $email_body = "$fname . \n" . "$lname . \n" . "heeft zich geregistreerd met mailadres: $email\n";
                      
        // $to="jacomijnsteen@gmail.com";
      
        // //mailsturen naar mijzelf
      
        // mail($to,$email_subject,$email_body,);
      
        // //mail sturen naar afzender van bericht
      
        // $email_subject_v = "van Jacomijn Steen";
        // $email_body_v = "Bedankt voor het inloggen in mijn blog.";
                        
      
        // mail($email_from, $email_subject_v, $email_body_v);
       
 // de geregistreerde gegevens opslaan in db personen
        include 'openConn.php';
        $connection = new PDO($dsn, $user_name, $pass_word);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
        $name = $_POST['name']; 
        $email = $_POST['email'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if(isset ($_POST['registreer'])){
            if(empty($name) || empty($password1) ||empty($email) || empty($password2)){
                echo "een van de velden is niet ingevuld";
            } elseif ($password1!==$password2){
                echo "de wachtwoorden zijn niet gelijk";
            } 
            
            $passwordReg = md5($password1);
            $checkdubbel = "SELECT * FROM  persons  WHERE email = '$email'";
            $result = $connection->query($checkdubbel);
            
            if ($result == $_POST['email']){

                echo "dit emailadres bestaat al ";
            }

            $newPersonSql = "INSERT INTO persons (name, email, password)
                                VALUES ('$name' , '$email' , '$passwordReg')";
            $result = $connection->exec($newPersonSql);
        
            if($result === 0) {
                $err = $connection->errorInfo();
                print_r($err);
            }
                echo "<strong> Registratie is gelukt. U kunt nu inloggen </strong>";    
        }        
            
    // close connection
        $connection = NULL;




 // inloggen

    
        include 'openConn.php';
        $connection = new PDO($dsn, $user_name, $pass_word);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
        $inlogEmail = $_POST['inlogEmail'];
        $inlogPassword = $_POST['inlogPassword'];
        
        if(isset($_POST['logIn'])){
       
            $passwordLogin = md5($inlogPassword);

                if(empty ($_POST['inlogEmail']) || empty ($_POST['inlogPassword'])){
                    echo "niet alle velden zijn ingevuld";
                } 
    // check alleen op email en password
                $emailPasswordCheck = "SELECT * FROM persons WHERE email = '$inlogEmail' AND  password = '$passwordLogin' ";

                $check = $connection->query($emailPasswordCheck);
                    if($check !== 1){
                        echo "naam en password combinatie onjuist";
                    } else {

                        header('blogtext.php');
                    }
        }
    // close connection
        $connection = NULL;
        ?>
       
    </body>
</html>

     