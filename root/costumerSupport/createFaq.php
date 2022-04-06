<?php
require_once("../config/config.php");
if (!in_array($_SESSION['role'], $answerTickets)) {
    header("location: ../costumerSupport/faq.php");
    exit;
}
$upload_err = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $root = '../faqPictures/';
    echo "MÅ LEGGE TIL TITLE I STMT OG HELE FAQ POST DRITEN <br>";
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $contents = mysqli_real_escape_string($link, $_POST['contents']);
    $stmt = "SELECT * FROM FAQ WHERE title = '$title'";
    $result = mysqli_query($link, $stmt);
    if (mysqli_num_rows($result) == 0) {
        $stmt = "INSERT INTO faq (title, contents) VALUES ('$title', '$contents')";
        if ($result = mysqli_query($link, $stmt)) {
            if ($_FILES) {
                for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
                    //finner navnet til filen, tmp navn, størrelse, om det er en feil og type fil
                    $fileName = mysqli_real_escape_string($link, $_FILES['file']['name'][$i]);
                    $fileTmpName = $_FILES['file']['tmp_name'][$i];
                    $fileSize = $_FILES['file']['size'][$i];
                    $fileError = $_FILES['file']['error'][$i];
                    $fileType  = $_FILES['file']['type'][$i];

                    //fjerner . og fil navnet fra filnavnet.fil slik at vi får både filnavn og fil til å være alene
                    $fileExt = explode('.', $fileName);
                    //gjør alle extensions til å være lower case slik at jeg slipper å skrive jPg, Jpg, JPG, osv
                    $fileActualExt = strtolower(end($fileExt));

                    //fil extensions som er lovlig på siden
                    $allowed = array('jpg', 'jpeg', 'png', 'svg');

                    //skjekker extensions som er lovlige å opploade imot filen som blir uploadea
                    if (in_array($fileActualExt, $allowed)) {
                        //hvis fileerror = 0 betyr det at det ikke er noen errors
                        if ($fileError === 0) {
                            //Hvis filstørrelsen er mindre enn 10mb
                            if ($fileSize < 1000000) {
                                //gir nytt random navn og legger til . + filen sin extension
                                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                                //destinasjon av filer
                                $fileDestination = $root . $fileNameNew;
                                $stmt = "insert into faqpic(path, lineNum, title) VALUES ('$fileDestination', '$i', '$title')";
                                $result = mysqli_query($link, $stmt);
                                //flytter filen til riktig desitnasjon
                                move_uploaded_file($fileTmpName, $fileDestination);
                                //variabel for filen som ble sendt med navn 'file'
                                $file = $_FILES['file'];
                            } else {
                                $upload_err = "Your file is too large!";
                            }
                        } else {
                            $upload_err = "There was an error uploading your file";
                        }
                    } else {
                        $upload_err = "You cannot upload files of this type!";
                    }
                }
            }
        } else {
            $upload_err = "Something went wrong, try again later";
        }
    } else {
        $upload_err = "Title already exists";
    }
    $stmt = "SELECT * FROM faq WHERE title = '$title'";
    $result = mysqli_query($link, $stmt);
    $rad = mysqli_fetch_assoc($result);
    $urlTitle = str_replace(' ', '-', $rad['title']);
    header("location:faqArticle.php?title=$urlTitle");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create faq article</title>
</head>

<body>
    <?php include('../config/navbar.php'); ?>
    <div class="whitespace"></div>
    <div class="containerBody">
        <?php echo $upload_err ?>
        <form action="createFaq.php" id="form" method="POST" enctype="multipart/form-data" class="column">
            <label class="supportLabel" for="">Title</label>
            <input class="supportTitle" required name="title" ; type="text" placeholder="Article title">
            <label class="supportLabel" for="">Description</label>
            <textarea required class="supportDescription" name="contents" id="" cols="30" rows="10" placeholder="Use * to create new line eg. This is line #1 * This is line #2"></textarea>
            <input type="number" min='0' width="50" onchange="addInputs()" onkeydown='addInputs()' ; name='pictureAmount' value='0'>
            <!--Skriver inputs fra js-->
            <div id="newInputs"></div>
            <input type="submit" class='input createButton' value="Publish">
        </form>

    </div>


    <script src='../script/ui.js'></script>
    <script src='../script/createFaq.js'></script>
</body>

</html>