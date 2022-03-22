<?php
require_once "../config/config.php";

//search engine
if (isset($_GET['k']) && $_GET['k'] != '') {
    //gjør at ' k ' blir til 'k'
    $k = trim(mysqli_real_escape_string($link, $_GET['k']));
    //keyword blir en array der hvert element blir separert med et mellomrom
    //"hei du" -> $keyword[0] = hei, $keyword[1] = du
    $keywords = explode(' ', $k);

    //query
    $searchStmt = "SELECT * FROM USERS WHERE";
    foreach ($keywords as $word) {
        $searchStmt .= " username like '%" . $word . "%' OR ";
        $display_words = "";
    }

    //fjerner den siste "OR" fra stringen for å ikke få feil
    //fjerner de siste 3 bokstavene fra stringen.
    $searchStmt = substr($searchStmt, 0, strlen($searchStmt) - 3);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Results for <?php echo ' ' . $k ?></title>
</head>

<body>
    <!-- navbar -->
    <?php include("../config/navbar.php")?>
    
    <div class="whitespace"> </div>
    <div class="container containerBody">
        <?php
        //kjører sql statement lenger opp i koden
        if ($result = mysqli_query($link, $searchStmt)) {
            //finner antall treff
            if ($result_num = mysqli_num_rows($result)) {
                if ($result_num > 0) {
                    //case 1: de som blir søkt på finnes
                    print 'Your search for&#160;<i> ' . $k . '</i> <hr /> <br/>';
                    print '<div class = ""><b><u>' . $result_num . '</u></b> results found</div>';
                    while ($row = mysqli_fetch_assoc($result)) { //henter all dataen
                        $brukernavn = $row['username'];
                        $profilePic = $row['profilePicPath'];
                        $bruker = "  <div class = 'result'  onClick=sendTilProfil('$brukernavn')>
                                        <div class = 'bigPfpRadius' >
                                            <img class = 'bigPfp'  src=" . $profilePic . " alt='$brukernavn'> 
                                        </div>
                                        <div class='column brukerSøk'>
                                            <h2 class = 'bruker'> $brukernavn </h2>
                                            <h2 class='desc light'> cap for nå</h2>
                                        </div>
                                        
                                    </div>";
                        echo $bruker;
                    }
                } else {
                    //case 2: de finnes ikke
                    print "no results found";
                }
            }
        } else {
            //hvis queryen feiler
            print(mysqli_error($link));
        }

        ?>
    </div>
    <div id="invisable"></div>
    <script src="../script/ui.js"> </script>
</body>

</html>