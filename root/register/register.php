<?php
require_once "../process/config.php";

$username_err = $password_err = $confirmPassword_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Setter som variabler
    //mysqli real escape string gjør at special characters som ' blir endret slik at man ikke kan injecte inn i sql.
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($link, $_POST['confirmPassword']);
    //feilsøking i brukernavn
    if (empty($_POST['username'])) {
        $username_err = "Please enter a username.";
        //sikkerhet slik at man ikke kan injecte også, hvis man kan legge til ' kan man lage kode selv.
    } else if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST['username']))) {
        $username_err = "Username can only contain letters, numbers and underscores.";
    } else {
        //ser om brukernavnet finnes
        $stmt = "SELECT * FROM USERS WHERE username = '$username'";
        if ($result = mysqli_query($link, $stmt)) {
            if (mysqli_num_rows($result) > 0) {
                $username_err = "Username already exists.";
            } else { //Ser om passord er gyldig
                if (empty($_POST['password']) || empty($_POST['confirmPassword'])) {
                    $password_err = "Please enter a password";
                } else if (!($password === $confirmPassword)) {
                    $password_err = "Password does not match.";
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = "INSERT INTO USERS (username, password, profilePicPath) VALUES ('$username', '$hashedPassword', '../profilbilder/standard.svg')";
                    if (mysqli_query($link, $stmt)) {
                        header("location: login.php");
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                }

                //ser om passordet er gyldig;

            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Login</title>
</head>

<body>

    <div class="center">
        <h1>Register</h1>
        <form action="register.php" method="POST">
            <div class="text-field">
                <input type="text" name = "username"required>
                <span></span>
                <label>Username</label>
            </div>
            <div class="text-field">
                <input type="password" name = "password" required>
                <span></span>
                <label>Password</label>
            </div>
            <div class="text-field">
                <input type="password" name = "confirmPassword" required>
                <span></span>
                <label>Confirm Password</label>
            </div>
            <input type="submit" value="Register">
            <p class="signup_link">Alreayd have an account? <a href="login.php"> Login</a></p>

    </div>
    </form>

</body>

</html>