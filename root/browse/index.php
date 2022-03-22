<?php

session_start();
require_once "../config/config.php";
//ser om du er logget inn
$followPage = false;
$username = $_SESSION["username"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
    </style>
</head>

<body>

    <?php include("../config/navbar.php")?>
    <div class="whitespace"> </div>


    <!--Bildet feed-->
    <div class="container containerBody">
        <?php

        //henter alle bilder som noen gang har blitt lagt ut
        $stmt = "SELECT * FROM BILDER";
        if ($result = mysqli_query($link, $stmt)) {
            //finner mengden bilder som finnes, altså rows i databasen
            if ($bildeCount = mysqli_num_rows($result)) {
                //kjører koden hver gang $rad får en ny verdi, altså for hver rad i databasen
                while ($rad = mysqli_fetch_assoc($result)) {
                    //definerer pathen til filen
                    $path = $rad['Path'];
                    $usernamePic = $rad['brukernavn'];
                    //elementet som skal vises
                    $bildeEl = "<div class = 'item center pointer' onClick = sendTilProfil('$usernamePic') > 
                                    <div class = 'bilder'> 
                                    <div class = 'blackbox'>
                                    </div >
                                        <img src = $path alt = 'bildet'> 
                                    </div> 
                                    
                                </div> ";
                    echo $bildeEl;
                }
            }
        }

        ?>
    </div>




    <div class="whitespace"></div>
    <p id="invisable"> </p>

    <script src="../script/ui.js"></script>
</body>

</html>