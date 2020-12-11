<?php
include("include/session.php");
if ($session->logged_in) {
    ?>
    <html>
        <head>
            <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"/>
            <title>Mano paskyra</title>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        </head>
        <body>       
				
                <?php
                //Jei vartotojas prisijungęs

                include("include/meniu.php");
                ?>
			<div class="container">
                
                          <  Atgal į [<a href="index.php">Pradžia</a>]
                                      
                <br> 
			<div class="panel panel-primary">
                            
			<div class="panel-heading">Paskyros duomenys</div>
			<div class="panel-body text-center">
                <?php
                /* Requested Username error checking */
                if (isset($_GET['user'])) {
                    $req_user = trim($_GET['user']);
                } else {
                    $req_user = null;
                }
                if (!$req_user || strlen($req_user) == 0 ||
                        !preg_match("/^([0-9a-zA-Z])+$/", $req_user) ||
                        !$database->usernameTaken($req_user)) {
                    echo "<br><br>";
                    die("Vartotojas nėra užsiregistravęs");
                }

                /* Display requested user information */
                $req_user_info = $database->getUserInfo($req_user);

                echo "<br><b>Vartotojo vardas: </b>" . $req_user_info['username'] . "<br><b>E-paštas: </b>" . $req_user_info['email'] . "<br>";
                //Jei vartotojas neprisijungęs, rodoma prisijungimo forma
                //Jei atsiranda klaidų, rodomi pranešimai.
                ?>
           </div>
			</div>
			</div>
    </body>
    </html>
    <?php
//Jei vartotojas neprisijungęs, užkraunamas pradinis puslapis  
} else {
    header("Location: index.php");
}
?>