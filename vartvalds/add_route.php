<?php
include("include/session.php");
if ($session->logged_in && $session->isAdmin()) {
		$servername = "localhost";
		$username = "stud";
		$password = "stud";
		$database = "vartvalds";
		$lentele="trips";


		$conn = new mysqli($servername, $username, $password, $database);
		
		if($conn->connect_error) die("Nepavyko prisijungti: " . $conn->connect_error);
	
		function checkIsAValidDate($myDateString){
    		return (bool)strtotime($myDateString);
		}
		
		
		if($_POST != null){
			
			if(!checkIsAValidDate($_POST['departureTime'])){
				header("Location:administrate_trains.php?fail=Netinkamas laikas!");exit;
			}
			
			if(strlen($_POST['price']) == 0 || !is_numeric($_POST['price']) || $_POST['price'] < 0){
				header("Location:administrate_trains.php?fail=Kaina netinkama!");exit;
			}
			
			if($_POST['departure_city'] == $_POST['arrival_city']){
				header("Location:administrate_trains.php?fail=Maršruto miestai negali sutapti!");exit;
			}
			
			if(strlen($_POST['departure_city']) == 0 || strlen($_POST['arrival_city']) == 0){
				header("Location:administrate_trains.php?fail=Netinkami maršruto miestai!");exit;
			}
			
			$departureTime = $_POST['departureTime'];
			
			$price = $_POST['price'];
			$train = $_POST['train'];
			
			$ticketCountsql = "SELECT seats_count as total FROM trains WHERE nr='$train'";
			if(!$ticketsResult0 = $conn->query($ticketCountsql)) {header("Location:administrate_trains.php?fail=Nukskaitymo klaida!");exit;}
			$ticket_count = mysqli_fetch_assoc($ticketsResult0)['total'];
			
			$departure_city = $_POST['departure_city'];
			$arrival_city = $_POST['arrival_city'];
			$sql = "INSERT INTO $lentele(departure_time,ticket_count,price,train_nr,departure_city_id,arrival_city_id) VALUES('$departureTime','$ticket_count','$price','$train','$departure_city','$arrival_city')";
			if(!$result=$conn->query($sql)) {header("Location:administrate_trains.php?fail=Įrašymo klaida!");exit;}
			echo "Irasyta";
			$conn->close();
			header("Location:administrate_trains.php?message=Reisas pridėtas sėkmingai");
			exit;
		}
		
	
} else {
    header("Location: index.php");
}
?>