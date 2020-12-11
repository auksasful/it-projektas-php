<?php
include("include/session.php");
if ($session->logged_in && !$session->isAdmin() && !$session->isManager() ) {
		$servername = "localhost";
		$username = "stud";
		$password = "stud";
		$database = "vartvalds";
		$lentele="tickets";


		$conn = new mysqli($servername, $username, $password, $database);
		
		if($conn->connect_error) die("Nepavyko prisijungti: " . $conn->connect_error);
		
		
		
		if($_POST != null){
			$ticket_id= $_POST['ticket_id'];
			if(strlen($_POST['tickets_count']) == 0 || !is_numeric($_POST['tickets_count']) || $_POST['tickets_count'] < 1){
				header("Location:buy_ticket.php?tripid=$ticket_id&fail=Netinkama bilietų kaina");exit;
			}
			if(strlen($_POST['client_name']) == 0){
				header("Location:buy_ticket.php?tripid=$ticket_id&fail=Kliento vardas negali būti tuščias!");exit;
			}
			
			if(strlen($_POST['client_surname']) == 0){
				header("Location:buy_ticket.php?tripid=$ticket_id&fail=Kliento vardas negali būti tuščias!");exit;
			}
			
			
			$username = $session->username;
			//$ticket_id= $_POST['ticket_id'];
			$client_name = $_POST['client_name'];
			$client_surname = $_POST['client_surname'];
			$tickets_count = $_POST['tickets_count'];
			
			
			$ticketCountsql = "SELECT ticket_count as total FROM trips WHERE id='$ticket_id'";
			if(!$ticketsResult0 = $conn->query($ticketCountsql)) die("Negaliu nuskaityti: " . $conn->error);
			$ticketCount = mysqli_fetch_assoc($ticketsResult0);
			$loc_sql3 = "SELECT SUM(tickets_count) as total FROM tickets WHERE tickets.trip_id='$ticket_id'";
			if(!$ticketsResult = $conn->query($loc_sql3)){ header("Location:buy_ticket.php?tripid=$ticket_id&fail=Skaitymo klaida! 1");exit;}
			$ticketsResult1 = mysqli_fetch_assoc($ticketsResult);
			if($ticketsResult1['total'] == null || $ticketsResult1['total'] == ""){
				$ticketsResult1['total'] = 0;
			}
			$difference =  (int)$ticketCount['total']-(int)$ticketsResult1['total'];
			
			
			if($tickets_count > $difference){
				header("Location:buy_ticket.php?tripid=$ticket_id&fail=Tiek bilietų nėra pardavime!");exit;
			}
			
			
			
			$sql = "INSERT INTO $lentele(client_username,client_name,client_surname,tickets_count,trip_id) VALUES('$username','$client_name','$client_surname','$tickets_count','$ticket_id')";
			if(!$result=$conn->query($sql)) {header("Location:buy_ticket.php?tripid=$ticket_id&fail=Įrašymo klaida!");exit;}
			echo "Irasyta";
			$conn->close();
			header("Location:tickets.php?message=Bilietas užsakytas sėkmingai");exit;
		}
		
	
} else {
    header("Location: index.php");
}
?>