<?php
include("include/session.php");
//if ($session->logged_in) {
    ?>
<!DOCTYPE html>
    <html lang="lt">
        <head>  
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

			<style>
				.row-striped:nth-of-type(odd){
				  background-color: #efefef;
				  border-left: 4px #000000 solid;
				}

				.row-striped:nth-of-type(even){
				  background-color: #ffffff;
				  border-left: 4px #efefef solid;
				}

				.row-striped {
					padding: 15px 0;
				}
				.list-inline {
					margin-left: 10px;
				}
				.text-uppercase{
				    margin-left: 10px;
				}
				
				#tripList{
					
  					
				}
				
			</style>
        </head>
        <body>
            
                        <?php
                        include("include/meniu.php");
                        ?>    
			<div class='container'>
                                   < Atgal į [<a href="index.php">Pradžia</a>]            
                        <br> 
			<div class="panel panel-primary">
				<div class="panel-heading">Traukinio reisų sąrašas</div>
				</div>
		<?php
		$servername = "localhost";
		$username = "stud";
		$password = "stud";
		$database = "vartvalds";
		$lentele="trips";


		$conn = new mysqli($servername, $username, $password, $database);
		
		if($conn->connect_error) die("Nepavyko prisijungti: " . $conn->connect_error);
		
		
		
		if($_POST != null && $session->logged_in){
			$departureTime = $_POST['departureTime'];
			$ticket_count = $_POST['ticket_count'];
			$price = $_POST['price'];
			$train = $_POST['train'];
			$departure_city = $_POST['departure_city'];
			$arrival_city = $_POST['arrival_city'];
			$sql = "INSERT INTO $lentele(departure_time,ticket_count,price,train_nr,departure_city_id,arrival_city_id) VALUES('$departureTime','$ticket_count','$price','$train','$departure_city','$arrival_city')";
			if(!$result=$conn->query($sql)) die("Negaliu irasyti ".$conn->error);
			echo "Irasyta";
			$conn->close();
			header("Location:operacija1.php");exit;
		}
		
		
		echo "<div class='container overflow-auto' id='tripList'>";
		
			
		
		$startEntry = 0;
		if(!isset($_GET["page"])){
			$curPage = 0;
		}
		else{
			$curPage = $_GET["page"] - 1;
			$startEntry = 5 * $curPage;
			
		}
			
		$cities = "SELECT * FROM cities";
		$trains = "SELECT * FROM trains";
		$sql="SELECT * FROM $lentele ORDER BY $lentele.departure_time LIMIT $startEntry, 5";
		if(!$citiesResult = $conn->query($cities)) die("Negaliu nuskaityti: " . $conn->error);
		if(!$citiesResult2 = $conn->query($cities)) die("Negaliu nuskaityti: " . $conn->error);
		if(!$trainsResult = $conn->query($trains)) die("Negaliu nuskaityti: " . $conn->error);
		if(!$result = $conn->query($sql)) die("Negaliu nuskaityti: " . $conn->error);
		

		while($row = $result->fetch_assoc()){
			$loc_sql1 = "SELECT * FROM cities WHERE cities.id=".$row['departure_city_id'];
			$loc_sql2 = "SELECT * FROM cities WHERE cities.id=".$row['arrival_city_id'];
			$loc_sql3 = "SELECT SUM(tickets_count) as total FROM tickets WHERE tickets.trip_id=".$row['id'];
			if(!$citiesResultDeparture = $conn->query($loc_sql1)) die("Negaliu nuskaityti: " . $conn->error);
			if(!$citiesResultArrival = $conn->query($loc_sql2)) die("Negaliu nuskaityti: " . $conn->error);
			if(!$ticketsResult = $conn->query($loc_sql3)) die("Negaliu nuskaityti: " . $conn->error);
			$citiesResultDeparture1 = $citiesResultDeparture->fetch_assoc();
			$citiesResultArrival1 = $citiesResultArrival->fetch_assoc();
			$ticketsResult1 = mysqli_fetch_assoc($ticketsResult);
			$difference = (int)htmlentities($row['ticket_count']) - (int)$ticketsResult1['total'];
			$sales = (int)$ticketsResult1['total'] * (int)htmlentities($row['price']);
			echo "
		<div class='row row-striped'>
		
			<div class='col-8'>
				<h3 class='text-uppercase'><strong>".$citiesResultDeparture1['name']." - ".$citiesResultArrival1['name']."</strong></h3>
				<ul class='list-inline'>
				&nbsp;
					<li class='list-inline-item'><i class='fa fa-train' aria-hidden='true'></i> Traukinio numeris: ".$row['train_nr']."</li>
					<li class='list-inline-item'><i class='fa fa-location-arrow' aria-hidden='true'></i> Išvykimo stotis: ".$citiesResultDeparture1['name']."</li>
					<li class='list-inline-item'><i class='fa fa-clock-o' aria-hidden='true'></i> Išvykimo laikas: ".htmlentities($row['departure_time'])."</li>
					<li class='list-inline-item'><i class='fa fa-money' aria-hidden='true'></i> Kaina: ".htmlentities($row['price'])." €</li>
					";
			if ($session->logged_in && !$session->isManager() && !$session->isAdmin()) {
					if($difference > 0) echo "<li class='list-inline-item'> <a href='buy_ticket.php?tripid=".$row['id']."'>Užsakyti bilietą</a></li>";
					else echo "<li class='list-inline-item'> Visi bilietai rezervuoti</li>";
				}
				if ($session->isManager() || $session->isAdmin()) {
					echo "
					</ul>
					<p>Bilietų skaičius: ".htmlentities($row['ticket_count'])."
					<br>
					Laisvų bilietų: ".$difference."
					<br>
					Užsakyta bilietų: ".(int)$ticketsResult1['total']."
					<br>
					Užsakyta bilietų už: ".$sales." €
					</p>
					";
				}
			
			echo "
			</div>
		</div>
			";
		}
		echo "</div>";
			
		$ticketCount = $conn->query("SELECT * FROM trips")->num_rows;
		$pagesCount = ceil($ticketCount / 5);
		echo "<br>";
		echo "Puslapiai:<br>";
		for($i = 1; $i <= $pagesCount; $i++){
			if($i != $curPage + 1){
				echo "<a href='view_tickets.php?page=$i'>$i</a>  ";
			}
			else{
				echo "<b>$i</b> ";
			}
		}
		
			
			
			
		$conn->close();
		?>
		</div>
		
</div>
<br><br><br><br>	
				
        </body>
			
			
    </html>
    <?php
    //Jei vartotojas neprisijungęs, užkraunamas pradinis puslapis  
//} else {
  //  header("Location: index.php");
//}
?>
		
		
			
		
		