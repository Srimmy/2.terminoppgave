<?php
require_once("../config/config.php");


//gjør om - til mellomrom
$title = str_replace('-', ' ', $_GET['title']);
//henter resten av artikkelen
$stmt = "SELECT * FROM faq WHERE title = '$title'";
if (mysqli_num_rows(mysqli_query($link, $stmt)) ==  0) {
    header("location: faq.php");
}
//gjør om hver * til en indeks i array
$contents = explode("*", mysqli_fetch_assoc(mysqli_query($link, $stmt))['contents']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
</head>

<body>
    <?php include('../config/navbar.php') ?>
    <div class="whitespace"></div>
    <div class="containerBody faq">

        <div class="faqArticle">
            <?php

            echo "
            <h5 class='faqTitle'>
                " . $title . "
            </h5>
            <p class='faqP'>
                <ol>";
            //Skriver hver linje av innholdet
            for ($i = 0; $i < count($contents); $i++) {
                if (strlen($contents[$i]) > 3) {
                    echo $contents[$i];
                    $stmt = "SELECT * FROM faqPic where title = '$title' and lineNum = '$i'";
                    if ($result = mysqli_query($link, $stmt)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($rad = mysqli_fetch_assoc($result)) {
                                echo "<img src = '" . $faqPicRoot.$rad['path'] . "' class = 'faqPic' alt = 'Picture that describes something, sorry if you're bind'>";
                            }
                        }
                    }
                }
            }


            ?>
        <div class="bottomWhiteSpace"></div>
            
        </div>
    </div>

    <script src = "../../script/ui.js"></script>
</body>

</html>