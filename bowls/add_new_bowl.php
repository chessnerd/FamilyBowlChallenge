<?php
require_once("database.php");

$name = NULL; // Name of the bowl game
$team1 = NULL; // team1 id
$team2 = NULL; // team2 id
$network = NULL; // TV Network
$type = NULL; // Type of bowl game
$gametime = NULL; // Gametime


if (isset($_POST['name']) && trim($_POST['name']) != "") {
        $name = trim($_POST['name']);
} else {
        header("Location: new_bowl_form.php?failed=no_bowl_name");
        exit;
}
if (isset($_POST['team1']) && trim($_POST['team1']) != 0) {
        $team1 = $_POST['team1'];
} else {
        header("Location: new_bowl_form.php?failed=no_team_1");
        exit;
}
if (isset($_POST['team2']) && trim($_POST['team2']) != 0) {
        $team2 = $_POST['team2'];
} else {
        header("Location: new_bowl_form.php?failed=no_team_2");
        exit;
}
if (isset($_POST['network']) && trim($_POST['network']) != "") {
        $network = trim($_POST['network']);
} else {
        header("Location: new_bowl_form.php?failed=no_network");
        exit;
}
if (isset($_POST['type']) && trim($_POST['type']) != 0) {
        $type = $_POST['type'];
} else {
        header("Location: new_bowl_form.php?failed=no_bowl_type");
        exit;
}
if (isset($_POST['date']) && trim($_POST['date']) != 0) {
        $gametime = $_POST['date'];
} else {
        header("Location: new_bowl_form.php?failed=no_date");
        exit;
}
if (isset($_POST['gametime']) && trim($_POST['gametime']) != 0) {
        $gametime = $gametime . " " . $_POST['gametime'];
} else {
        header("Location: new_bowl_form.php?failed=no_time");
        exit;
}


// Create connection and enter data
try {
        $sql = "INSERT INTO Bowls (name, gametime, team1, team2, tv_network, game_type) VALUES ('$name', '$gametime', '$team1', '$team2', '$network', '$type')";
        $statement = $conn->prepare($sql);
        $success = $statement->execute();
        if ($success) {
                header("Location: update_bowls.php?success=true");
                exit;   header("Location: new_bowl_form.php?failed=bad_database1");
        } //else { Do nothing }
} catch (PDOException $e) {
        //echo $sql . "<br>" . $e->getMessage();
        if (strpos($e->getMessage(), "Duplicate entry")) {
                header("Location: new_bowl_form.php?failed=name_taken&name=" . $name);
        } else {
                header("Location: new_bowl_form.php?failed=bad_database2");
        }
        exit;
}

header("Location: new_bowl_form.php?failed=unknown");

?>
