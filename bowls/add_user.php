<?php
require_once("database.php");

$a_name = NULL; // Actual name of player
$p_name = NULL; // Player name
$user = NULL; // Username
$pass = NULL; // Password
$answer = NULL; // Security question answer


if (isset($_POST['security'])) {
	$answer = $_POST['security'];
} else {
	header("Location: new_user.php?failed=bad_security");
	exit;
}
if ($answer != "Mey" && $answer != "mey") {
	header("Location: new_user.php?failed=bad_security");
	exit;
}
if (isset($_POST['actual_name']) && trim($_POST['actual_name']) != "") {
	$a_name = $_POST['actual_name'];
} else {
	header("Location: new_user.php?failed=no_actual_name");
	exit;
}
if (isset($_POST['player_name']) && trim($_POST['player_name']) != "") {
        $p_name = $_POST['player_name'];
} else {
        header("Location: new_user.php?failed=no_player_name");
        exit;
}
if (isset($_POST['username']) && trim($_POST['username']) != "") {
        $user = trim($_POST['username']);
} else {
        header("Location: new_user.php?failed=no_username");
        exit;
}
if (isset($_POST['password']) && trim($_POST['password']) != "") {
        $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
} else {
        header("Location: new_user.php?failed=no_password");
        exit;
}


// Create connection and enter data
try {
	$sql = "INSERT INTO Players (actual_name, player_name, username, password) VALUES ('$a_name', '$p_name', '$user', '$pass')";
	$statement = $conn->prepare($sql);
	$success = $statement->execute();
	if ($success) {
		header("Location: login.php?new_user=true&username=" . $user);
		exit;	header("Location: new_user.php?failed=bad_database");
	} //else { Do nothing }
} catch (PDOException $e) {
	//echo $sql . "<br>" . $e->getMessage();
	if (strpos($e->getMessage(), "Duplicate entry")) {
		header("Location: new_user.php?failed=name_taken&username=" . $user);
	} else {
		header("Location: new_user.php?failed=bad_database");
	}
	exit;
}

header("Location: new_user.php?failed=unknown");

?>
