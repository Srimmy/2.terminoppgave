<?php
require_once "../process/config.php";

//search engine
if (isset($_GET['k']) && $_GET['k'] != '') {
    //gjør at ' k ' blir til 'k'
    $k = trim(mysqli_real_escape_string($link, $_GET['k']));
    //keyword blir en array der hvert element blir separert med et mellomrom
    //"hei du" -> $keyword[0] = hei, $keyword[1] = du
    $keywords = explode(' ', $k);

    //query
    $stmt = "SELECT * FROM USERS WHERE";
    foreach ($keywords as $word) {
        $stmt .= " username like '%" . $word . "%' OR ";
        $display_words = "";
    }

    //fjerner den siste "OR" fra stringen for å ikke få feil
    //fjerner de siste 3 bokstavene fra stringen.
    $stmt = substr($stmt, 0, strlen($stmt) - 3);
    print($stmt);

    if ($result = mysqli_query($link, $stmt)) {
        if ($result_num = mysqli_num_rows($result)) {
            if ($result_num > 0) {
                print 'Your search for <i>' . $display_words . '</i> <hr /> <br/>';
                print '<div class = ""><b><u>' . $result_num . '</u></b> results found</div>';
                while ($row = mysqli_fetch_assoc($result)) {
                    print $row['username'];
                }
            } else {
                print "no results found";
            }
        }
    } else {
        print(mysqli_error($link));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Results for <?php echo $k ?></title>
</head>
<body>
    
</body>
</html>
