<?php
require_once "../config/config.php";

//definerer feilmeldinger
$login_err = "";

//hvis noen har brukt formen i html
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    //hvis det begge er fyllt
    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM users where username = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        if ($result = mysqli_stmt_get_result($stmt)) {
            //henter data i assoc array
            if ($user_data = mysqli_fetch_assoc($result)) {
                //skjekker om dataen stemmer, funker ikke gjøre om passordet til hashed og teste d
                if (password_verify($password, $user_data['password'])) {
                    //lager session slik at variabler lagrer seg, gjør det lettere senere
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $user_data['id'];
                    $_SESSION['username'] = $user_data['username'];
                    $_SESSION['highscore'] = $user_data['highscore'];
                    $_SESSION['password'] = $user_data['password'];
                    $_SESSION['role'] = $user_data['role'];
                    if (is_null($user_data['profilePicPath'])) {
                        $_SESSION['profilePic'] = "../profilbilder/standard.svg";
                    } else {
                        $_SESSION['profilePic'] =  $profilePicRoot.$user_data['profilePicPath'];
                    }


                    //tar deg til index.php
                    header("location: ../browse/index.php?fraNewlogin");
                } else {
                    $login_err = "Invalid username or password."; //$login_err er allerede i html koden, bare at den ikke er definert
                }
            } else {
                $login_err = "Invalid username or password.";
            }
        } else {
            $login_err = "Something went wrong, try again later.";
        }
    } else {
        $login_err = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/login.css">
    <title>Login</title>
</head>

<body>

    <div class="center">
        <h1>Login</h1>
        <form action="login.php" method="POST">
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
            <input type="submit" value="login">
            <p class="signup_link">Don't have an account?<a href="register.php" class="link"> Sign up</a></p>

    </div>
    </form>

</body>

</html>