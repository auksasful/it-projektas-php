<?php
include("include/session.php");
if ($session->logged_in) {
    header("Location: index.php");
} else {
    ?>
    <html>
        <head>  
            <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"/> 
            <title>Registracija</title>
			<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    
      <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css"> -->
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css"> 
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker-standalone.css"> 
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



        </head>
        <body>                 
                        <?php
                        /**
                         * The user has submitted the registration form and the
                         * results have been processed.
                         */ if (isset($_SESSION['regsuccess'])) {
                            /* Registracija sėkminga */
                            if ($_SESSION['regsuccess']) {
                                echo "<p>Ačiū, <b>" . $_SESSION['reguname'] . "</b>, Jūsų duomenys buvo sėkmingai įvesti į duomenų bazę, galite "
                                . "<a href=\"index.php\">prisijungti</a>.</p><br>";
                            }
                            /* Registracija nesėkminga */ else {
                                echo "<p>Atsiprašome, bet vartotojo <b>" . $_SESSION['reguname'] . "</b>, "
                                . " registracija nebuvo sėkmingai baigta.<br>Bandykite vėliau.</p>";
                            }
                            unset($_SESSION['regsuccess']);
                            unset($_SESSION['reguname']);
                        }
                        /**
                         * The user has not filled out the registration form yet.
                         * Below is the page with the sign-up form, the names
                         * of the input fields are important and should not
                         * be changed.
                         */ else {
                            ?>
                            <div align="center">
                                <?php
                                if ($form->num_errors > 0) {
                                    echo "<font size=\"3\" color=\"#ff0000\">Klaidų: " . $form->num_errors . "</font>";
                                }
                                ?>    
								
								<div class="container">
									  <  Atgal į [<a href="index.php">Pradžia</a>]
                               <div class="panel panel-primary">
                            
							<div class="panel-heading text-center">Registracija</div>
							<div class="panel-body text-center">
                                            <form action="process.php" method="POST" class="login">              
                
                                                <p>Vartotojo vardas:<br>
                                                    <input class ="s1" name="user" type="text" size="15"
                                                           value="<?php echo $form->value("user"); ?>"/><br><?php echo $form->error("user"); ?>
                                                </p>
                                                <p >Slaptažodis:<br>
                                                    <input class ="s1" name="pass" type="password" size="15"
                                                           value="<?php echo $form->value("pass"); ?>"/><br><?php echo $form->error("pass"); ?>
                                                </p>  
                                                <p >E-paštas:<br>
                                                    <input class ="s1" name="email" type="text" size="15"
                                                           value="<?php echo $form->value("email"); ?>"/><br><?php echo $form->error("email"); ?>
                                                </p>  
                                                <p >
                                                    <input type="hidden" name="subjoin" value="1">
                                                    <input type="submit" value="Registruotis">
                                                </p>
                                            </form>
                                        </div>
                            </div>
									</div>
                            <?php
                        }

                        include("include/footer.php");
                        ?>
   
        
        </body>
    </html>
    <?php
}
?>
