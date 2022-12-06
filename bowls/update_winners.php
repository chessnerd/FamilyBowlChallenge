<?php
require_once("database.php");
require_once("session.php");

try {
$post_keys = array_keys($_POST);
foreach($post_keys as $bowl) {
	$bowl_id = substr($bowl, 4);
	// Update the winner of the game
	$stmt = $conn->prepare('UPDATE Bowls SET winner=' . $_POST[$bowl] . ' WHERE id=' . $bowl_id);
	$stmt->execute();
}
} catch (PDOException $e) {
	// Do nothing yet
	//echo $e->getMessage();
	header("Location: admin_cp.php?winners_updated=false");
}

header("Location: current.php");
?>
