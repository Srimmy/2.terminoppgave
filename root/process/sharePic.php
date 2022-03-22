<?php

require_once "../config/config.php";
$root = '../delteBilder/';
$Id = $_SESSION['id'];
$username = $_SESSION['username'];
//https://www.youtube.com/watch?v=JaRq73y5MJk
//skjekker om knappen er trykket ved å se om det har blitt submitta en post som heter submit
if (isset($_POST['submit'])) {
    //variabel for filen som ble sendt med navn 'file'
    $file = $_FILES['file'];

    //finner navnet til filen, tmp navn, størrelse, om det er en feil og type fil
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType  = $_FILES['file']['type'];

    //fjerner . og fil navnet fra filnavnet.fil slik at vi får både filnavn og fil til å være alene
    $fileExt = explode('.', $fileName);
    //gjør alle extensions til å være lower case slik at jeg slipper å skrive jPg, Jpg, JPG, osv
    $fileActualExt = strtolower(end($fileExt));

    //fil extensions som er lovlig på siden
    $allowed = array('jpg', 'jpeg', 'png', 'svg');

    //skjekker extensions som er lovlige å opploade imot filen som blir uploade'a
    if (in_array($fileActualExt, $allowed)) {
        //hvis fileerror = 0 betyr det at det ikke er noen errors
        if ($fileError === 0) {
            //Hvis filstørrelsen er mindre enn 10mb
            if ($fileSize < 1000000) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                //destinasjon av filer
                $fileDestination = $root . $fileNameNew;
                $stmt = "INSERT INTO bilder(Path, brukernavn) values('$fileDestination', '$username')";
                $result = mysqli_query($link, $stmt);
                //flytter filen til riktig desitnasjon
                move_uploaded_file($fileTmpName, $fileDestination);

                header("Location: ../profile/profile.php?uploadFromSharePic");
            } else {
                echo "Your file is too large!";
            }
        } else {
            echo "There was an error uploading your file";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}

?>
