<?php
require_once("Template.php");
$json = file_get_contents("./assets/albumMocks.json");
$mock = json_decode($json, true);


//  Lucas Db stuff here

// Lucas db end result
$result = $mock["mockData"];

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
        <ul>
            <li><a class="link navLink" href="./privacy.php"><div class="btn btn__text">PRIVACY</div></a></li>
            <li><a class="link navLink" href="./survey.php"><div class="btn btn__text">SURVEY</div></a></li>
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
            </tr>
        </thead>
        <tbody>';
            foreach ($result as $record) {
                print "<tr>
                <td>
                {$record['albumartist']}
                </td>
                <td>
                {$record['albumtitle']}
                </td>
                <td class='lengthData'>
                {$record['albumlength']}
                </td>";
            }
print '</tbody>
        </table>
        </div>
        </div>
    </div>
</div>';


?>