<?php

require_once("session.php");
$title = "User Authentication";
require_once("database.php");

if (isset($_POST['username']) and trim($_POST['username']) != "" && isset($_POST['password'])) {
	// Do Nothing
} else {
	// Redirect back
	header("Location: login.php");
	exit;
}

$user = trim($_POST['username']);
$playerName = $user;
$id = 0;

try {
	$verify = $conn->prepare("SELECT password from Players where username= :name");
	$verify->execute(array(':name' => $user));
	$row = $verify->fetch(PDO::FETCH_ASSOC);
	if (password_verify($_POST['password'], $row["password"])) {
		// PASSWORDS MATCH! Keep going!
	} else {
		header("Location: login.php?login_failed=true&username=" . $user);
		exit;
	}
	$getPlayerName = $conn->prepare("SELECT player_name from Players where username= :name");
	$getPlayerName->execute(array(':name' => $user));
	$row = $getPlayerName->fetch(PDO::FETCH_ASSOC);
	$playerName = $row["player_name"];
	$getPlayerID = $conn->prepare("SELECT id from Players where username= :name");
	$getPlayerID->execute(array(':name' => $user));
	$row = $getPlayerID->fetch(PDO::FETCH_ASSOC);
	$id = $row["id"];
} catch (PDOException $e) {
	echo "Database failure - cannot get user data: " . $e->getMessage();
}

$_SESSION['username'] = $user;
$_SESSION['playerName'] = $playerName;
$_SESSION['player_id'] = $id;

header("Location: userpage.php");

?>
