
<?php
include("include/session.php");
if ($session->logged_in && !$session->isAdmin() && !$session->isManager()) {
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
					overflow-y:auto;
  					height: 400px;
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
				if(isset($_GET['fail'])){
					echo "
					<div class='alert alert-danger'>
  						<strong>".$_GET['fail']."</strong>
					</div>
					";
				}
			?>
			
			
			  <div class="panel panel-primary">
				<div class="panel-heading">Bilieto užsakymas</div>
				</div>
		<?php
		$servername = "localhost";
		$username = "stud";
		$password = "stud";
		$database = "vartvalds";
		$lentele="trips";


		$conn = new mysqli($servername, $username, $password, $database);
		
		if($conn->connect_error) die("Nepavyko prisijungti: " . $conn->connect_error);
		
		
		
		if($_POST != null){
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
		
		
		
		
		$cities = "SELECT * FROM cities";
		$trains = "SELECT * FROM trains";
		$sql="SELECT * FROM $lentele WHERE id = ". $_GET['tripid'];
		if(!$citiesResult = $conn->query($cities)) die("Negaliu nuskaityti: " . $conn->error);
		if(!$citiesResult2 = $conn->query($cities)) die("Negaliu nuskaityti: " . $conn->error);
		if(!$trainsResult = $conn->query($trains)) die("Negaliu nuskaityti: " . $conn->error);
		if(!$result = $conn->query($sql)) die("Negaliu nuskaityti: " . $conn->error);
		
		echo "<div class='container'>";

		$row = $result->fetch_assoc();
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
				</ul>
			</div>
		</div>
			";
		
		echo "</div>";

		$conn->close();
		?>
		
		
		
		 
		
		<br>
		
		  <div class="panel panel-primary">
				<div class="panel-heading">Užsakyti bilietą</div>
				</div>
	
	<form method='post' action='buy_ticket_process.php'>
		<div class="container">
          <div class="row">
			
			<div class="col-sm">
			  Keleivio vardas:<br>  
				<input type="text" name="client_name" class="form-control"/>
			</div>
			
			<div class="col-sm">
			  Keleivio pavardė:<br>  
				<input type="text" name="client_surname" class="form-control"/>
			</div>
		  <div class="col-sm">
		  Užsakytų bilietų kiekis:<br>  
			<input type="text" name="tickets_count" class="form-control"/>
			</div>
			<input type='hidden' name='username' value='<?php echo "$session->username";?>'/> 
			<input type='hidden' name='ticket_id' value='<?php echo (int)$_GET['tripid'];?>'/> 
			
			<input type='submit' name='ok' value='Patvirtinti'>
		  </div>
		
       </div>
			
		
		 </div>
		
		
		
	</form>
                 
				
				
			
				</div>  
        </body>
			
			
    </html>
    <?php
    //Jei vartotojas neprisijungęs, užkraunamas pradinis puslapis  
} else {
    header("Location: index.php");
}
?>
		
		
			
		
		