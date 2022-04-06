<?php
require_once("../config/config.php");
$search = false;
//search engine
if (isset($_GET['k']) && $_GET['k'] != '') {
    $search = true;
    //gjør at ' k ' blir til 'k'
    $k = trim(mysqli_real_escape_string($link, $_GET['k']));
    //keyword blir en array der hvert element blir separert med et mellomrom
    //"hei du" -> $keyword[0] = hei, $keyword[1] = du
    $keywords = explode(' ', $k);

    //query
    $searchStmt = "SELECT * FROM faq WHERE";
    foreach ($keywords as $word) {
        $searchStmt .= " title like '%" . $word . "%' OR ";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
</head>

<body>
    <?php include('../config/navbar.php'); ?>
    <div class="whitespace"></div>
    <div class="containerBody  faq">
        <form method="GET" class="faqBackground " id="faqSearchForm" action='faq.php'>
            <input name="k" id="faqSearch" type="text" class="faqSearch">
            <label for="faqSearch" name="faqSearchLabel" id="faqLabel" class="faqSearch">What can we help you with?</label>
        </form>
        <?php
        if ($search) {
            //kjører sql statement lenger opp i koden
            if ($result = mysqli_query($link, $searchStmt)) {
                //finner antall treff
                if ($result_num = mysqli_num_rows($result)) {
                    if ($result_num > 0) {
                        //case 1: de som blir søkt på finnes
                        print '<b><u>' . $result_num . '</u></b> results found for &apos;<i>'. $k . '</i>&apos;. <a class="link" href="../costumerSupport/allFaq.php">Browse knowledge base </a> <hr /> <br/>';
                        while ($rad = mysqli_fetch_assoc($result)) { //henter all dataen
                            $urlTitle = str_replace(' ', '-', $rad['title']);
                            echo "<a href='http://localhost/dashboard/terminoppgave/root/costumerSupport/faqArticle.php?title=" . $urlTitle . "'>" . $rad['title'] . "</a> <br>";
                        }
                    }
                } else {
                    //case 2: de finnes ikke
                    print 'No results found for &apos;<i>'. $k .'</i>&apos;.  <a class="link" href="../costumerSupport/allFaq.php">Browse knowledge base </a> <hr /> <br/>';
                }
            } else {
                //hvis queryen feiler
                print(mysqli_error($link));
            }
        }


        ?>

    </div>
    <script src='../script/ui.js'></script>
    <script src='../script/faqSearch.js'></script>
</body>

</html>