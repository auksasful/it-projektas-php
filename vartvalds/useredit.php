<?php
include("include/session.php");
if ($session->logged_in) {
    ?>
    <html>
        <head>
            <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"/> 
            <title>Paskyros redagavimas</title>
        </head>
        <body>       
                        <?php
                        /**
                         * User has submitted form without errors and user's
                         * account has been edited successfully.
                         */
                        include("include/meniu.php");
                        ?> 
			<div class="container">
                                   < Atgal į [<a href="index.php">Pradžia</a>]           
                        <br> 
                        <?php
                        if (isset($_SESSION['useredit'])) {
                            unset($_SESSION['useredit']);
                            echo "<p><b>$session->username</b>, Jūsų paskyra buvo sėkmingai atnaujinta.<br><br>";
                        } else {
                            echo "<div align=\"center\">";
                            if ($form->num_errors > 0) {
                                echo "<font size=\"3\" color=\"#ff0000\">Klaidų: " . $form->num_errors . "</font>";
                            } else {
                                echo "";
                            }
                            ?>
			 <div class="panel-group">
			<div class="panel panel-primary">
                            
									<div class="panel-heading">Paskyros redagavimas</div>
									<div class="panel-body text-center">
                                        <form action="process.php" method="POST">
                                            <p>Dabartinis slaptažodis:<br>
                                                <input type="password" name="curpass" maxlength="30" size="25" value="<?php echo $form->value("curpass"); ?>">
                                                <br><?php echo $form->error("curpass"); ?></p>
                                            <p>Naujas slaptažodis:<br>
                                                <input type="password" name="newpass" maxlength="30" size="25" value="<?php echo $form->value("newpass"); ?>">
                                                <br><?php echo $form->error("newpass"); ?></p>
                                            <p>E-paštas:<br>
                                                <input type="text" name="email" maxlength="30" size="25" value="<?php
                    if ($form->value("email") == "") {
                        echo $session->userinfo['email'];
                    } else {
                        echo $form->value("email");
                    }
                            ?>"> <br><?php echo $form->error("email"); ?></p>
                                            <input type="hidden" name="subedit" value="1">
                                            <input type="submit" value="Atnaujinti">
                                        </form>
										</div>
                                    
				</div>
</div>


                            <?php
                            echo "</div>";
                        }
                        ?>
                    </div>
        </body>
    </html>      
    <?php
    //Jei vartotojas neprisijungęs, užkraunamas pradinis puslapis  
} else {
    header("Location: index.php");
}
?>