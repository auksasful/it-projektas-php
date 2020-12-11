<?php
include("include/session.php");
if ($session->logged_in && $session->isAdmin()) {
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
                       <h1>Traukinio reisų administravimas</h1>
		<?php
		$servername = "localhost";
		$username = "stud";
		$password = "stud";
		$database = "vartvalds";
		$lentele="trips";


		$conn = new mysqli($servername, $username, $password, $database);
		
		if($conn->connect_error) die("Nepavyko prisijungti: " . $conn->connect_error);
		
		
		
		
		
		
		
		$cities = "SELECT * FROM cities";
		$trains = "SELECT * FROM trains";
		$sql="SELECT * FROM $lentele ORDER BY $lentele.departure_time";
		if(!$citiesResult = $conn->query($cities)) die("Negaliu nuskaityti: " . $conn->error);
		if(!$citiesResult2 = $conn->query($cities)) die("Negaliu nuskaityti: " . $conn->error);
		if(!$trainsResult = $conn->query($trains)) die("Negaliu nuskaityti: " . $conn->error);
		if(!$result = $conn->query($sql)) die("Negaliu nuskaityti: " . $conn->error);
		

		$conn->close();
		?>
		
		
		
		 
		
		
		
		
	 <div class="panel panel-primary">
				<div class="panel-heading">Įvesti naują maršrutą</div>
				</div>
	<form method='post' action='add_route.php'>
		<div class="container">
          <div class="row">
            <div class='col-sm-6'>
                <div class="form-group">
					Išvykimo laikas:
                    <div class='input-group date' id='datetimepicker1'>
                        <input name='departureTime' type='text' class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(function () {
                    $('#datetimepicker1').datetimepicker({
					 format: 'YYYY-MM-DD HH:ss'
					});
                });
            </script>
          </div>
			
			<div class="col-sm">
			  Bilieto kaina €:<br>  
				<input type="text" name="price" class="form-control"/>
			</div>
			
			<div class="col-sm">
			  Traukinio numeris:<br>  
				<select name="train" id="trains">
					<?php
				while($row = $trainsResult->fetch_assoc()){
					echo"<option value='".$row['nr']."'>".$row['nr']." (".$row['seats_count']." vietų)</option>";
				}
				?>
  				</select><br><br>
			</div>
			<div class="col-sm">
			  Išvykimo stotis:<br> 
				<select name="departure_city" id="departure_cities">
					<?php
				while($row = $citiesResult->fetch_assoc()){
					echo"<option value='".$row['id']."'>".$row['name']."</option>";
				}
				?>
  				</select><br><br>
			</div>
			  <div class="col-sm">
			  Atvykimo stotis:<br> 
				  <select name="arrival_city" id="arrival_cities">
					<?php
				while($row = $citiesResult2->fetch_assoc()){
					echo"<option value='".$row['id']."'>".$row['name']."</option>";
				}
				?>
  				</select><br><br>
			</div>
			<input type='submit' name='ok' value='Patvirtinti'>
		  </div>
		
       
		
	
		
		
		
	</form>
			<br>
			<hr>
			
			<br>
			 <div class="panel panel-primary">
				<div class="panel-heading">Pridėti naują stotį</div>
				</div>
	<form method='post' action='add_station.php'>
		<div class="container">
          <div class="row">
           
			<div class="col-sm">
			  Stoties pavadinimas:<br>  
				<input type="text" name="station_name" class="form-control"/>
			</div>
			<br>
			<input type='submit' name='ok' value='Patvirtinti'>
		  </div>
		
       </div>
			
		
		
		
		
		
	</form>
		
		
		
			<br>
			<hr>
			
			<br>
			 <div class="panel panel-primary">
				<div class="panel-heading">Pridėti naują traukinį</div>
				</div>
	<form method='post' action='add_train.php'>
		<div class="container">
          <div class="row">
           
			<div class="col-sm">
			  Traukinio numeris:<br>  
				<input type="text" name="train_number" class="form-control"/>
			</div>
			  
			 <div class="col-sm">
			  Vietų skaičius:<br>  
				<input type="text" name="seats_count" class="form-control"/>
			</div>
			<br>
			<input type='submit' name='ok' value='Patvirtinti'>
		  </div>
		
       </div>
			
		
		 
		
		
		
	</form>

<br><br>	
				<script type="text/javascript">
                $(function () {
                    $('#datetimepicker1').datetimepicker();
                });
            </script>
        </body>
			
			
    </html>
    <?php
    //Jei vartotojas neprisijungęs, užkraunamas pradinis puslapis  
} else {
    header("Location: index.php");
}
?>
		
		
			
		
		