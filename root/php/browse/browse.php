<?php
require_once "../config/config.php";
$username = "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Browse</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>

    <!-- navbar -->
    <?php include("../config/navbar.php") ?>


    <div class="whitespace"></div>
    <p>
        <a href="sharePic.php">Share a picture</a>
    </p>

    <!--Bildet feed-->
    <div class="container containerBody">
        <?php
        $stmt = "SELECT * FROM bilder";
        if ($result = mysqli_query($link, $stmt)) {
            //finner mengden bilder som finnes, altså rows i databasen
            if ($bildeCount = mysqli_num_rows($result)) {
                //kjører koden hver gang $rad får en ny verdi, altså for hver rad i databasen
                while ($rad = mysqli_fetch_assoc($result)) {
                    //definerer pathen til filen
                    $path = $postedPicRoot . $rad['Path'];
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
    

    <script src="../../script/ui.js"></script>
</body>

</html>