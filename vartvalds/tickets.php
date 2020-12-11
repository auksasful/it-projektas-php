<?php
include("include/session.php");
if ($session->logged_in && !$session->isAdmin() && !$session->isManager()) {
    ?>
    <html>
        <head>  
            <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"/> 
            <title>Operacija2</title>
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
							<?php
				if(isset($_GET['message'])){
					echo "
					<div class='alert alert-success'>
  						<strong>".$_GET['message']."</strong>
					</div>
					";
				}
			?>
			
			<?php
				if(isset($_GET['fail'])){
					echo "
					<div class='alert alert-danger'>
  						<strong>".$_GET['fail']."</strong>
					</div>
					";
				}
			?>
			
                        <br> 
                 <div class="panel panel-primary">
				<div class="panel-heading">Vartotojo užsakyti bilietai</div>
				</div>
        <?php
		$servername = "localhost";
		$username = "stud";
		$password = "stud";
		$database = "vartvalds";
		$lentele="tickets";


		$conn = new mysqli($servername, $username, $password, $database);
		
		if($conn->connect_error) die("Nepavyko prisijungti: " . $conn->connect_error);
		
	
	
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
		$sql="SELECT * FROM trips INNER JOIN tickets on trips.id = tickets.trip_id AND tickets.client_username='$session->username' ORDER BY trips.departure_time LIMIT $startEntry, 5";
		if(!$citiesResult = $conn->query($cities)) die("Negaliu nuskaityti: " . $conn->error);
		if(!$citiesResult2 = $conn->query($cities)) die("Negaliu nuskaityti: " . $conn->error);
		if(!$trainsResult = $conn->query($trains)) die("Negaliu nuskaityti: " . $conn->error);
		if(!$result = $conn->query($sql)) die("Negaliu nuskaityti: " . $conn->error);
		
		echo "<div class='container overflow-auto' id='tripList'>";
		$rowCounter = 0;
		while($row = $result->fetch_assoc()){
			$rowCounter++;
			$loc_sql1 = "SELECT * FROM cities WHERE cities.id=".$row['departure_city_id'];
			$loc_sql2 = "SELECT * FROM cities WHERE cities.id=".$row['arrival_city_id'];
			//$loc_sql3 = "SELECT * FROM tickets WHERE tickets.trip_id=".(int)$row['id']." AND tickets.client_username='$session->username'";
			//echo (int)$row['id']." '$session->username'"; 
			if(!$citiesResultDeparture = $conn->query($loc_sql1)) die("Negaliu nuskaityti: " . $conn->error);
			if(!$citiesResultArrival = $conn->query($loc_sql2)) die("Negaliu nuskaityti: " . $conn->error);
			//if(!$ticketsResult = $conn->query($loc_sql3)) die("Negaliu nuskaityti: " . $conn->error);
			$citiesResultDeparture1 = $citiesResultDeparture->fetch_assoc();
			$citiesResultArrival1 = $citiesResultArrival->fetch_assoc();
			//$ticketsResult1 = $ticketsResult->fetch_assoc();
			$sumTickets = htmlentities($row['price']) * htmlentities($row['tickets_count']);
			echo "
		<div class='row row-striped'>
		
			<div class='col-8'>
				<h3 class='text-uppercase'><strong>".$citiesResultDeparture1['name']." - ".$citiesResultArrival1['name']."</strong></h3>
				<ul class='list-inline'>
				&nbsp;
					<li class='list-inline-item'><i class='fa fa-train' aria-hidden='true'></i> Traukinio numeris: ".$row['train_nr']."</li>
					<li class='list-inline-item'><i class='fa fa-location-arrow' aria-hidden='true'></i> Išvykimo stotis: ".$citiesResultDeparture1['name']."</li>
					<li class='list-inline-item'><i class='fa fa-clock-o' aria-hidden='true'></i> Išvykimo laikas: ".htmlentities($row['departure_time'])."</li>
					<li class='list-inline-item'><i class='fa fa-calculator' aria-hidden='true'></i> Kiekis: ".htmlentities($row['tickets_count'])."</li>
					<li class='list-inline-item'><i class='fa fa-money' aria-hidden='true'></i> Bilieto kaina: ".htmlentities($row['price'])." €</li>
					<li class='list-inline-item'><i class='fa fa-money' aria-hidden='true'></i> Suma: $sumTickets €</li>
					<li class='list-inline-item'> <a href='cancel_ticket.php?ticket_id=".$row['id']."'>Atsisakyti bilieto</a></li>
				</ul>
				<p>Keleivio vardas: ".htmlentities($row['client_name'])."
				<br>
				Keleivio pavardė: ".$row['client_surname']."
				</p>
			</div>
		</div>
			";
		}
		if($rowCounter == 0){
			echo "Užsakytų bilietų nėra";
		}
		echo "</div>";
		
		if($rowCounter != 0){
			$ticketCount = $conn->query("SELECT * FROM trips INNER JOIN tickets on trips.id = tickets.trip_id AND tickets.client_username='$session->username'")->num_rows;
			$pagesCount = ceil($ticketCount / 5);
			echo "<br>";
			echo "Puslapiai:<br>";
			for($i = 1; $i <= $pagesCount; $i++){
				if($i != $curPage + 1){
					echo "<a href='tickets.php?page=$i'>$i</a>  ";
				}
				else{
					echo "<b>$i</b> ";
				}
			}
		}
	
	
		$conn->close();
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