<?php
require_once "../config/config.php";
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../browse/browse.php");
    exit;
} else if (!in_array($_SESSION['role'], $answerTickets)) {
    header("location: ../browse/index.php");
    exit;
}
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Incomming tickets</title>
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
            <a class="menu" href="../browse/index.php"><img class="navbar-icon" src="../htmlBilder/browse.png" alt="explore"></a>
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
    <div class="whitespace"> </div>

    <div class="containerBody">
        <div>
            <table class="ticketTable">
                <tr>

                    <th>ID</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Requester</th>
                    <th>Asignee</th>

                </tr>

                <?php
                //henter alle tickets
                $stmt = "SELECT * FROM ticket ORDER BY created_at asc";
                if ($result = mysqli_query($link, $stmt)) {
                    while ($rad = mysqli_fetch_assoc($result)) {
                        $id = $rad['id'];
                        $title = $rad['keyword'];
                        $desc = $rad['description'];
                        if (strlen($desc) > 25) {
                            $desc = substr($desc, 0, 22) . '...';
                        }
                        $user = $rad['user'];
                        $answerer = $rad['answerer'];
                        if (is_null($answerer)) {
                            $answerer = "-";
                        }
                        $priority = $rad['priority'];
                        echo "
                    <tr onclick=seeTicket('$id')>
                        <td>
                            #$id
                        </td>
                        <td>
                            $title
                        </td>
                        <td>
                            $desc
                        </td>
                        <td>
                            $user
                        </td>
                        <td>
                            $answerer
                        </td>
                    </tr>";
                    }
                }
                ?>
            </table>
        </div>
    </div>
    <div id="invisable"></div>
    <script src="../script/ui.js"></script>

</body>

</html>