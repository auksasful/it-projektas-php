<?php
include("include/session.php");
if ($session->logged_in) {
		$servername = "localhost";
		$username = "stud";
		$password = "stud";
		$database = "vartvalds";
		$lentele="trains";


		$conn = new mysqli($servername, $username, $password, $database);
		
		if($conn->connect_error) die("Nepavyko prisijungti: " . $conn->connect_error);
		
		
		
		if($_POST != null){
			if(strlen($_POST['train_number']) == 0){
				header("Location:administrate_trains.php?fail=Traukinio numeris netinkamas!");exit;
			}
			
			if(strlen($_POST['seats_count']) == 0 || !is_numeric($_POST['seats_count']) || $_POST['seats_count'] < 1){
				header("Location:administrate_trains.php?fail=Vietų skaičius netinkamas!");exit;
			}
			
			$train_number = $_POST['train_number'];
			$seats_count = $_POST['seats_count'];
			$sql = "INSERT INTO $lentele(nr, seats_count) VALUES('$train_number', '$seats_count')";
			if(!$result=$conn->query($sql)) {header("Location:administrate_trains.php?fail=Įrašymo klaida!");exit;}
			echo "Irasyta";
			$conn->close();
			header("Location:administrate_trains.php?message=Traukinys pridėtas sėkmingai");exit;
		}
		
	
} else {
    header("Location: index.php");
}
?>