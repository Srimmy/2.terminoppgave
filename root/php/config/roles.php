<?php
require_once("config.php");

//henter alle mulige roller fra databasen og gir roller der det trengs
$answerTickets = array();
$stmt = "SELECT * FROM roleprivileges where privileges = 'answerTicket'";
if($result = mysqli_query($link, $stmt)) {
    while($rad = mysqli_fetch_assoc($result)) {
    array_push($answerTickets, $rad['role']);
    }
    var_dump($answerTickets);
}


?>