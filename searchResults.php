<?php
require_once("./assets/Template.php");
require_once("./assets/DB.class.php");
$json = file_get_contents("./assets/albumMocks.json");
//$mock = json_decode($json, true);
session_start();

if(isset($_POST["search"])){
	$albums = $_POST['search'];
    $dataJson = json_encode($albums);
    $postString = "data=" . urlencode($dataJson);
    $contentLength = strlen($postString);

    $header = array(
    'Content-Type: application/x-www-form-urlencoded',
    'Content-Length: ' . $contentLength
    );

    $url = "cnmtsrv2.uwsp.edu/~lsode062/sprint1/backend/albumdata-database.php";
    $ch = curl_init();

    curl_setopt($ch,
        CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch,
        CURLOPT_POSTFIELDS, $postString);
    curl_setopt($ch,
        CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $returnData = curl_exec($ch);
    $result = json_decode($returnData, true);

    curl_close($ch);
} else {
	echo "<h4>No Results!</h4>";
}
if (empty($response)){
	print "No Results!";
}
$page = new Template("Search Results");
$page->addHeadElement('<link rel="stylesheet" href="./assets/styles/normalize.css">');
$page->addHeadElement('<link rel="stylesheet" type="text/css" href="./assets/styles/styles.css">');
$page->addHeadElement('<link href="https://fonts.googleapis.com/css?family=Krub|PT+Sans|Ubuntu" rel="stylesheet">');
$page->finalizeTopSection();
$page->finalizeBottomSection();

print $page->getTopSection();

print '<div class="content">
<header id="header">
    <div>
        <a class="link" href="./index.php">
        <h1 class="siteTitle">
                CNMT Survey
            </h1>
        </a>
    </div>
    <span class="flexSpace"></span>
<nav>
    <ul>';
        if (isset($_SESSION['role']))
        {
            echo $User = "Welcome " . $_SESSION['user'];
            echo '<li><a class="link navLink" href="./logout.php"><div class="btn btn__text">LOGOUT</div></a></li>';
        }
        else
        {
            echo '<li><a class="link navLink" href="./login.php"><div class="btn btn__text">LOGIN</div></a></li>';
        }
		if (isset($_SESSION['roles']) && (in_array('admin', $_SESSION['roles']))) {
                print '<li><a class="link navLink" href="./SurveyData.php"><div class="btn btn__text">DATA</div></a></li>';
            }
print  '<li><a class="link navLink" href="./privacy.php"><div class="btn btn__text">PRIVACY</div></a></li>
        <li><a class="link navLink" href="./survey.php"><div class="btn btn__text">SURVEY</div></a></li>
        <li><a class="link navLink" href="./searchAlbums.php"><div class="btn btn__text">SEARCH</div></a></li>
    </ul>
</nav>
</header>
<div class="paneContainer">
    <div class="pane">
    <div class="resultContent">
            <h1 class="privacyContent__title">Album Search Results</h1>
        <table>
        <thead>
            <tr>
                <th>
                    Album Artist
                </th>
                <th>
                    Album Title
                </th>
                <th>
                    Album Length (minutes)
                </th>
				<th>
                    Purchase Album
                </th>
            </tr>
        </thead>
        <tbody>';

foreach($result as $albums) {
	print "<tr>";
	foreach($albums as $key => $album) {
		print "<td>".$album."</td>";
	}
	print "</tr>";
}

print '</tbody>
        </table>
        </div>
        </div>
    </div>
</div>';


?>
