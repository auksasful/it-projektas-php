<?php
include("include/session.php");
?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"/>
        <title>IT projektas</title>
    </head>
    <body>             
         
            <?php
			include("include/meniu.php");
			echo "<div class='container'>";
            //Jei vartotojas prisijungęs
            if ($session->logged_in) {
                
                ?>
                <div style="text-align: center;color:green">
                    <br><br>
					<h1>Darbo pavadinimas: Traukinių bilietų užsakymas</h1>
                    <h1>Darbo autorius: Tomas Staškevičius</h1>
                </div><br>
                <?php
                //Jei vartotojas neprisijungęs, rodoma prisijungimo forma
                //Jei atsiranda klaidų, rodomi pranešimai.
            } else {
                //echo "<div>";
                if ($form->num_errors > 0) {
                    echo "<font size=\"3\" color=\"#ff0000\">Klaidų: " . $form->num_errors . "</font>";
                }
				
                include("include/loginForm.php");
            }
            include("include/footer.php");
            ?>
        </div>
</body>
</html>