<?php
include("include/session.php");
if ($session->logged_in && $session->isAdmin()) {
		$servername = "localhost";
		$username = "stud";
		$password = "stud";
		$database = "vartvalds";
		$lentele="cities";


		$conn = new mysqli($servername, $username, $password, $database);
		
		if($conn->connect_error) die("Nepavyko prisijungti: " . $conn->connect_error);
		
		
		
		if($_POST != null){
			if(strlen($_POST['station_name']) < 1){
				header("Location:administrate_trains.php?fail=Stoties pavadinimas netinkamas!");exit;
			}
			$station_name = $_POST['station_name'];
			$sql = "INSERT INTO $lentele(name) VALUES('$station_name')";
			if(!$result=$conn->query($sql)) {header("Location:administrate_trains.php?fail=Įrašymo klaida!");exit;}
			echo "Irasyta";
			$conn->close();
			header("Location:administrate_trains.php?message=Stotis pridėta sėkmingai");exit;
		}
		
	
} else {
    header("Location: index.php");
}
?>