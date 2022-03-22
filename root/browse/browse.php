<?php
session_start();
require_once "../config/config.php";
$username = "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Browse</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <!-- navbar -->
    <div class="navbar">
        <div class="left-navbar">
            <img src="../htmlBilder/logo.png" alt="logo" class="logo">
        </div>
        <form method="GET" class="row searchForm" action='../browse/search.php'>
            <div id="search" style="width: 15vw">
                <img src="../htmlBilder/søke.png" id="søkeBildet" alt="">
                <input class="search" id="searchText" name="k" type="text" class="search" placeholder="Search">
            </div>
        </form>
        <div class="right-navbar">
            <a class="menu" href="../browse/following.php"><img class="navbar-icon" src="../htmlBilder/house.png" alt="home"></a>
            <a class="menu" href="../browse/index.php"><img class="navbar-icon" src="../htmlBilder/browse-reverse.png" alt="explore"></a>
            <a class="menu" href="../game/pong.php"><img class="navbar-icon" src="../htmlBilder/pong.png" alt="explore"></a>
            <!--modal-->
            <a class="menu" id="modalButton"><img class="navbar-icon" src="../htmlBilder/share-button.png" alt="upload picture"></a>
            <div id="modalParent" onclick="hideModal(event)">
                <div id="modalChild">
                    <form action="../process/sharePic.php" method="POST" enctype="multipart/form-data">
                        <div class="modalTitleDiv">
                            <h2 class="modalTitle">Create a new post</h2>
                            <input class="" id="uploadPicture" type="submit" name="submit" value="Upload">
                        </div>
                        <div class="preview">
                            <img style="display: none;" id="picturePreview">
                        </div>

                        <label for="uploadInput" class="input submit" id="fileUpload"> Select from computer</label>
                        <!--Live preview av bildet-->
                        <input type="file" accept="image/*" onchange="showPreview(event);" id="uploadInput" name="file">
                    </form>
                </div>
            </div>
            <div id="pfpRadius" class="dropdownElement pfpRadius">
                <img class="profilBildet" id="drop" src="<?php echo $_SESSION['profilePic']; ?>" alt="profile picture">
            </div>


            <div id="dropDown" class="shadow">
                <div class="dropContainer ">
                    <a class="dropElement" href="../profile/profile.php">Profil</a>
                    <a class="dropElement" href="../profile/profileEdit.php">Edit profile</a>
                    <a class="dropElement" href="../costumerSupport/tickets.php">Tickets</a>
                    <?php
                    //ser om du har en rolle som lar deg se tickets
                    $stmt = "SELECT * FROM USERS WHERE USERNAME = '$username'";
                    if ($rad = mysqli_fetch_assoc(mysqli_query($link, $stmt))) {
                        if (in_array($rad['role'], $answerTickets)) {
                            echo '<a class="dropElement" href="../costumerSupport/openTicket.php">Answer tickets</a>';
                        }
                    }
                    ?>
                    <a class="dropElement" href="../process/logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </div>

    </div>


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
    <script src="../script/ui.js"></script>
</body>

</html>