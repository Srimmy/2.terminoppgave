<?php

#Henter andre filer og kobler sammen
#Dette skjekker om brukeren faktisk er logget inn eller ikke og er en type security
session_start();
include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //hvis denne if testen er sann, har noen skrevet informasjon i en form der metoden i formen var "POST"
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    //sjekker om brukernavn feltet er skrevet, om passordfeltet er skrevet og om brukernavnet inneholder bokstaver
    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        //skriven en query
        $usercheck = "select * from users where user_name = '$user_name' limit 1";
        //gjør queryen i variablen resultat der $con er connectionen mellom php og databasen og $usercheck er queryen
        $result = mysqli_query($con, $usercheck);
        //tester om resultatet har flere enn 0 rows, hvis det er fler enn 0 betyr det at dette brukernavnet fins i databasen
        if ($result && mysqli_num_rows($result) > 0) {
            echo "brukernavnet er allerede tatt";
        } else {
            //lager et random nummer (henter fra functions.php)
            $user_id = random_num(20);
            //lagre til dagrabase
            $query = "insert into users (user_id, user_name, password) values ('$user_id', '$user_name', '$password')";

            mysqli_query($con, $query);

            header("Location: login.php");
            die;
        }
    } else {
        echo "Please enter some valid information!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Sign up</title>
</head>

<body>
    <div class="skrivefelt">
        <form method="post" class="form">
            <label for="user_name">Username</label> <br>
            <input type="text" name="user_name"> <br> <br>
            <label for="password">Password</label> <br>
            <input type="password" name="password"> <br> <br>
            <label for="ConfirmPassword">Confirm password</label> <br>
            <input type="password" name="confirmPassword"> <br> <br>

            <input type="submit" value="Signup"> <br> <br>

            <a href="login.php"> Already have an account?</a> <br> <br>
        </form>
    </div>

</body>

</html>