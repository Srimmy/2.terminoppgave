<?php
$link = mysqli_connect("localhost", "root", "", "users");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
// fra roles
$answerTickets = array();
$stmt = "SELECT * FROM roleprivileges where privileges = 'answerTicket'";
if($result = mysqli_query($link, $stmt)) {
    while($rad = mysqli_fetch_assoc($result)) {
    array_push($answerTickets, $rad['role']);
    }
}
