<?php
require_once("session.php");
require_once("time_settings.php");

if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
}

$title = "Manage " . $_SESSION['playerName'];
require_once("header.php");
?>

<h2 <?php if($mobile) { echo "style=\"font-size:400%\"";} ?> >Bowl Challenge <?php echo $current_year; ?></h2>

<?php
require_once("user_cp.php");

echo "<br>";

if (isset($_GET['picks_updated'])) {
	if ($_GET['picks_updated'] == "true") {
		echo "<p style=\"color:blue\"><b>Your picks have been saved!</b></p>";
	} else {
		echo "<p style=\"color:red\"><b>Server Error! Your picks were not saved!</b></p>";
	}
} else if (isset($_GET['update_password'])) {
	if ($_GET['update_password'] == "true") {
                echo "<p style=\"color:blue\"><b>Your password has been updated!</b></p>";
        } else {
                echo "<p style=\"color:red\"><b>Server Error! Your password was not updated!</b></p>";
        }
}

if (isset($_GET['sparty'])) {
        if ($_GET['sparty'] == "true") {
                echo "<p style=\"color:red\"><b>Possible Error Detected: The Spartans were picked to win their bowl game!</b></p>";
        }
}

if (isset($_GET['shmuckeyes'])) {
        if ($_GET['shmuckeyes'] == "true") {
                echo "<p style=\"color:red\"><b>Possible Error Detected: The Buckeyes were picked to win their bowl game!</b></p>";
        }
}

date_default_timezone_set("America/Detroit");
if (strtotime("now") < strtotime($first_game_kickoff_time)) {
	echo "<h3 style=\"font-size:160%\">" . "Manage " . $_SESSION['playerName'] . "'s Picks</h3>";
	require_once("picks.php");
} else {
	echo "<h3 style=\"font-size:160%\">" . "Run Analysis for " . $_SESSION['playerName'] . "</h3>";
	require_once("analysis.php");
}

?>

<br><hr>
<?php require_once("footer.php"); ?>
