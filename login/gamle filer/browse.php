<?php
require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/pictures.css">
    <title>bildeGalleri</title>
</head>

<body>


    <a href="welcome.php">Back to home page</a> <br>
    <div class="container">
        <?php
        $stmt = "SELECT * FROM bilder";
        if ($result = mysqli_query($link, $stmt)) {
            //finner mengden bilder som finnes, altså rows i databasen
            if ($bildeCount = mysqli_num_rows($result)) {
                //kjører koden hver gang $rad får en ny verdi, altså for hver rad i databasen
                while ($rad = mysqli_fetch_assoc($result)) {
                    //definerer pathen til filen
                    $path = $rad['Path'];
                    $usernamePic = $rad['brukernavn'];
                    //elementet som skal vises
                    $bildeEl = "<div class = 'item'> 
                                    <div class = 'bilder'> 
                                        <img src = $path alt = 'bildet'> 
                                    </div> 
                                    <div class = 'middle'>
                                        <p class = 'username'> $usernamePic</p>
                                    </div> 
                                </div> ";

                    echo $bildeEl;
                }
            }
        }

        ?>
    </div>



</body>

</html>