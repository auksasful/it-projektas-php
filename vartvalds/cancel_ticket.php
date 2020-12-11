<?php
include("include/session.php");
if ($session->logged_in && !$session->isAdmin() && !$session->isManager()) {
		$servername = "localhost";
		$username = "stud";
		$password = "stud";
		$database = "vartvalds";
		$lentele="tickets";


		$conn = new mysqli($servername, $username, $password, $database);
		
		if($conn->connect_error) die("Nepavyko prisijungti: " . $conn->connect_error);
		
		echo "hello";
		
		if($_GET != null){
			$username = $session->username;
			$ticket_id= $_GET['ticket_id'];
			
			
			$sql = "DELETE FROM $lentele WHERE $lentele.id = '$ticket_id' AND $lentele.client_username = '$username'";
			if(!$result=$conn->query($sql)) {header("Location:tickets.php?fail=Nepavyko atsisakyti bilieto!");exit;}
			echo "Irasyta";
			$conn->close();
			header("Location:tickets.php?message=Bilietų atsisakyta sėkmingai");exit;
		}
		
	
} else {
    header("Location: index.php");
}
?>