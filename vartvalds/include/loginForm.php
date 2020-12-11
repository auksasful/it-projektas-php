<?php
if (isset($form) && isset($session) && !$session->logged_in) {
    ?>   
	<h1 style="text-align:center;"><a href="view_tickets.php">Peržiūrėti traukinių grafiką kaip svečias</a></h1>
	<hr>
	<div class="panel panel-primary">
                            
		<div class="panel-heading text-center">Prisijungimas</div>
		<div class="panel-body text-center">
    <form action="process.php" method="POST" class="login">              
        <p style="text-align:center;">Vartotojo vardas:<br>
            <input class ="s1" name="user" type="text" value="<?php echo $form->value("user"); ?>"/><br>
            <?php echo $form->error("user"); ?>
        </p>
        <p style="text-align:center;">Slaptažodis:<br>
            <input class ="s1" name="pass" type="password" value="<?php echo $form->value("pass"); ?>"/><br>
            <?php echo $form->error("pass"); ?>
        </p>  
        <p style="text-align:center;">
            <input type="submit" value="Prisijungti"/>
            <input type="checkbox" name="remember" 
            <?php
            if ($form->value("remember") != "") {
                echo "Pažymėtas";
            }
            ?>/>
            Atsiminti   
        </p>
        <input type="hidden" name="sublogin" value="1"/>
        <p style="text-align:center;">
            <a href="forgotpass.php">Negalite prisijungti?</a>&nbsp;&nbsp;            
            <a href="register.php">Registracija</a>
        </p>     
    </form>
			</div>
    <?php
}
?>