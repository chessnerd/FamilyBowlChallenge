<?php
// We need to have session data for this page
require_once("session.php");

// If the session data isn't set, kick the user to the login page
if (!isset($_SESSION['player_id'])) {
        header("Location: login.php");
        exit;
}

// We are also going to need the database
require_once("database.php");

// Check to see if the user is an admin
$admin = array();
try {
        $stmt = $conn->query("SELECT admin FROM Players where id=" . $_SESSION['player_id']);
        $admin = $stmt->fetch(PDO::FETCH_NUM);
} catch (PDOException $e) {
        $admin[0] = false; // If there are any problems, we have to assume the user is not an admin
}

// Not an admin? Back to the regular userpage with the plebian!
if (!$admin[0]) {
        header("Location: userpage.php");
        exit;
}

// If we made it this far, we want the header for the page
$title = "Add a New Bowl";
require_once("header.php");

// Prepare to use the databae
require_once("database.php");
?>

<h2>Add a New Bowl</h2>

<form action="add_new_bowl.php" method="post" class="pure-form">

<b>Bowl Name: </b>
<input type="text" name="name" class="pure-input" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> ><br>
<b> Team 1: </b>

<?php
echo "<select class=\"pure-input\""; 
if ($mobile){ echo " style=\"font-size:200%\""; } 
echo " name=\"team1\">";

try {
// Get the names and ids of all teams
$stmt = $conn->query("SELECT id,name FROM Teams ORDER BY name ASC");
$count = 0;
$team_list = "<option value=\"0\">Select Team</option> ";
foreach( $stmt->fetchAll(PDO::FETCH_ASSOC) as $row ) {
        $team_name = $row['name'];
        $team_id = $row['id'];

		// Add the next team to the list
		$team_list = $team_list . "<option value=\"" . $team_id . "\">" . $team_name . "</option> ";
} // <-- End of getting the team names and ids

} catch (PDOException $e) {
        //Do nothing yet
}

echo $team_list;

echo "</select>";
?>

<b> Team 2: </b>

<?php
echo "<select class=\"pure-input\""; 
if ($mobile){ echo " style=\"font-size:200%\""; } 
echo " name=\"team2\">";

try {
// Get the names and ids of all teams
$stmt = $conn->query("SELECT id,name FROM Teams ORDER BY name ASC");
$count = 0;
$team_list = "<option value=\"0\">Select Team</option> ";
foreach( $stmt->fetchAll(PDO::FETCH_ASSOC) as $row ) {
        $team_name = $row['name'];
        $team_id = $row['id'];

		// Add the next team to the list
		$team_list = $team_list . "<option value=\"" . $team_id . "\">" . $team_name . "</option> ";
} // <-- End of getting the team names and ids

} catch (PDOException $e) {
        //Do nothing yet
}

echo $team_list;

echo "</select>";
?>

<b> TV Network: </b>
<input type="text" name="network" class="pure-input" value="ESPN" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> ><br>

<b> Bowl Type: </b>
<select class="pure-input" name="type" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> >
<option value ="1">Standard</option> <option value ="2">New Year's Six</option> <option value ="3">Playoff</option> <option value ="4">Championship</option> </select> <br>

<b> Gametime: </b>
<input type="date" id="date" name="date">
<input type="time" id="gametime" name="gametime">
<br><br>

&nbsp;<button type="submit" value="Add" class="pure-button pure-button-primary" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> >Add New Bowl</button>

</form>
