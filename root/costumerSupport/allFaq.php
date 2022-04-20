<?php
require_once('../config/config.php')

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include('../config/navbar.php') ?>
    <div class="whitespace"></div>
    <div class="containerBody faq">

        <div class="faqArticle">
            <?php
            $stmt = "SELECT * FROM faq";
            if ($result = mysqli_query($link, $stmt)) {
                while ($rad = mysqli_fetch_assoc($result)) {
                    //endrer %20% til - i url
                    $urlTitle = str_replace(' ', '-', $rad['title']);
                    echo "<a href='http://localhost/dashboard/terminoppgave/root/costumerSupport/faqArticle.php?title=" . $urlTitle . "'>" . $rad['title'] . "</a> <br>";
                }
            } ?>
            <div class="bottomWhiteSpace"></div>

        </div>
    </div>

    <script src="../script/ui.js"></script>
    <div class="containerBody">

    </div>

</body>

</html>