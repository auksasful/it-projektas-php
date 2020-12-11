<?php
include("include/session.php");
?>
<html>
    <head>  
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"/> 
        <title>Slaptažodžio priminimas</title>
       
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
        
                    <br>
		<div class="container">
									  <  Atgal į [<a href="index.php">Pradžia</a>]
                               <div class="panel panel-primary">
                            
							<div class="panel-heading text-center">Slaptažodžio sugražinimas</div>
							<div class="panel-body text-center">
                    <?php
                    /**
                     * Forgot Password form has been submitted and no errors
                     * were found with the form (the username is in the database)
                     */
                    if (isset($_SESSION['forgotpass'])) {
                        /**
                         * New password was generated for user and sent to user's
                         * email address.
                         */
                        if ($_SESSION['forgotpass']) {
                            echo "<p>Naujas slaptažodis buvo sugeneruotas ir nusiųstas paštu. <br><br></p>";
                        } else {
                            /**
                             * Email could not be sent, therefore password was not
                             * edited in the database.
                             */
                            echo "<h1>Klaida</h1>";
                            echo "<p>Įvyko klaida siunčiant slaptažodį.<br> "
                            . "<a href=\"index.php\">Pradžia</a>.</p>";
                        }
                        unset($_SESSION['forgotpass']);
                    } else {
                        /**
                         * Forgot password form is displayed, if error found
                         * it is displayed.
                         */
                        ?>
                      <div>
                        Naujas slaptažodis bus nusiųstas su Jūsų paskyra susietu e-pašto adresu.<br>
                        Įveskite vartotojo vardą:<br><br>
                        <?php
                        echo $form->error("user");
                        ?>
                        <form action="process.php" method="POST">
                            <input type="text" name="user" maxlength="30" value="<?php echo $form->value("user"); ?>">
                            <input type="hidden" name="subforgot" value="1">
                            <input type="submit" value="Naujas slaptažodis">
                        </form>
                      </div>
                        <?php
                    }

                    include("include/footer.php");
                    ?>
	</div>
	</div>
    </body>
</html>