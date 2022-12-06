<?php
require_once("database.php");
require_once("session.php");

$sparty = false;
$shmuckeyes = false;

try {
$get_keys = array_keys($_GET);
foreach($get_keys as $bowl) {
        if ($_GET[$bowl] != 0) {
                $bowl_id = substr($bowl, 4);
                // Find out if there is already a record for this game
                $stmt = $conn->prepare('SELECT * FROM Picks WHERE player=' . $_SESSION['player_id'] . " AND bowl=" . $bowl_id);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                // If there is not already a record
		if (! $row) {
//			echo "new pick - " . $_SESSION['player_id'] . ", " . $bowl_id . ", " . $_GET[$bowl];
                        $stmt = $conn->prepare("INSERT INTO Picks (player, bowl, team_pick) VALUES (" . $_SESSION['player_id'] . ", " . $bowl_id . ", " . $_GET[$bowl]. ")");
                        $stmt->execute();
                } else {
//			echo "old pick - " . $_SESSION['player_id'] . ", " . $bowl_id . ", " . $_GET[$bowl];
                        $stmt = $conn->prepare("UPDATE Picks SET team_pick=" . $_GET[$bowl] . " WHERE player=" . $_SESSION['player_id'] . " AND bowl=" . $bowl_id); 
                        $stmt->execute();
                }

		// Spartans bowl game and selection number
		if ($bowl_id == 6 && $_GET[$bowl] == 1) {
                        $sparty = true;
                }

		// Buckeyes bowl game and selection number
                if ($bowl_id == 1 && $_GET[$bowl] == 1) {
                        $shmuckeyes = true;
                }
        }
}
} catch (PDOException $e) {
        // Do nothing yet
        //echo $e->getMessage();
        header("Location: userpage.php?picks_updated=false");
}
$head1 = "Location: userpage.php?picks_updated=true";

if ($sparty) {
        $head1 = $head1 . "&sparty=true";
}
if ($shmuckeyes) {
	$head1 = $head1 . "&shmuckeyes=true";
}
//else {
	header($head1);
?>

