<head>
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

<?php
//Formuojamas meniu.
if (isset($session) && $session->logged_in) {
    $path = "";
    if (isset($_SESSION['path'])) {
        $path = $_SESSION['path'];
        unset($_SESSION['path']);
    }
    ?>


	<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Traukinių bilietų užsakymo sistema</a><br>
		<?php echo "Prisijungęs vartotojas: <b>$session->username</b> <br>"; ?>
    </div>
    <ul class="nav navbar-nav">
        <?php
        if (!$session->isAdmin() && !$session->isManager()) {
        echo " <li><a href=\"" . $path . "userinfo.php?user=$session->username\">Mano paskyra</a></li>"
			. " <li><a href=\"" . $path . "useredit.php\">Redaguoti paskyrą</a></li>"
			. " <li><a href=\"" . $path . "tickets.php\">Mano bilietai</a></li>"
			. " <li><a href=\"" . $path . "view_tickets.php\">Užsakyti bilietą</a></li>";
		}
		else{
			echo " <li><a href=\"" . $path . "userinfo.php?user=$session->username\">Mano paskyra</a></li>"
			. " <li><a href=\"" . $path . "useredit.php\">Redaguoti paskyrą</a></li>"
			. " <li><a href=\"" . $path . "view_tickets.php\">Visi maršrutai</a></li>";
		}
        //Trečia operacija rodoma administratoriui
        if ($session->isAdmin()) {
			echo "<li><a href=\"" . $path . "administrate_trains.php\">Administruoti reisus</a></li>";
        }
        //Administratoriaus sąsaja rodoma tik administratoriui
        if ($session->isAdmin()) {
			echo "<li><a href=\"" . $path . "admin/admin.php\">Administratoriaus sąsaja</a></li>";
        }
		echo "<li><a href=\"" . $path . "process.php\">Atsijungti</a></li>";
        ?>
    </ul>
  </div>
</nav>
    <?php
}//Meniu baigtas
?>
<?php
/*
  //Arba galime padaryti tą patį meniu aprašydami klase, ir sukurdami jos tipo objektą.
  class Meniu {

  function Meniu($session) {
  if (isset($session) && $session->logged_in) {
  $path = "";
  if (isset($_SESSION['path'])) {
  $path = $_SESSION['path'];
  unset($_SESSION['path']);
  }
  ?>
  <table width=100% border="0" cellspacing="1" cellpadding="3" class="meniu">
  <?php
  echo "<tr><td>";
  echo "Prisijungęs vartotojas: <b>$session->username</b> <br>";
  echo "</td></tr><tr><td>";
  echo "[<a href=\"" . $path . "userinfo.php?user=$session->username\">Mano paskyra</a>] &nbsp;&nbsp;"
  . "[<a href=\"" . $path . "useredit.php\">Redaguoti paskyrą</a>] &nbsp;&nbsp;"
  . "[<a href=\"" . $path . "tickets.php\">Mano bilietai</a>] &nbsp;&nbsp;"
  . "[<a href=\"" . $path . "view_tickets.php\">Užsakyti bilietą</a>] &nbsp;&nbsp;";
  //Trečia operacija rodoma valdytojui ir administratoriui
  if ($session->isManager() || $session->isAdmin()) {
  echo "[<a href=\"" . $path . "administrate_trains.php\">Administruoti bilietus</a>] &nbsp;&nbsp;";
  }
  //Administratoriaus sąsaja rodoma tik administratoriui
  if ($session->isAdmin()) {
  echo "[<a href=\"" . $path . "admin/admin.php\">Administratoriaus sąsaja</a>] &nbsp;&nbsp;";
  }
  echo "[<a href=\"" . $path . "process.php\">Atsijungti</a>]";
  echo "</td></tr>";
  ?>
  </table>
  <?php
  }
  }

  }

  //Sukuriamas objektas
  if (isset($session)) {
  $meniu = new Meniu($session);
  }
 */
?>