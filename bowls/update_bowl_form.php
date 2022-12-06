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
$title = "Update a Bowl";
require_once("header.php");

// Now prepare to use the database
require_once("database.php");

// Figure out which bowl we'er updating and remember its data
try {
	if (isset($_GET['id']) && trim($_GET['id']) != "") {
	        $id = $_GET['id'];
	} else {
	        header("Location: update_bowls.php?failed=no_bowl_id");
        	exit;
	}
	$stmt = $conn->query("SELECT * FROM Bowls WHERE id='$id'");
	$game_data=NULL;
	foreach( $stmt->fetchAll(PDO::FETCH_ASSOC) as $data) {
		$game_data=$data;
	}
	$bowl_name = $game_data['name'];
	$gametime = $game_data['gametime'];
	$team1 = $game_data['team1'];
	$team2 = $game_data['team2'];
	$game_type = $game_data['game_type'];
	$tv_network = $game_data['tv_network'];
} catch (PDOException $e) {
        //Do nothing yet
}
?>
<h2>Update the <?php echo $bowl_name ?></h2>

<form action="update_bowl.php?id=<?php echo $id ?>" method="post" class="pure-form">

<b>Bowl Name: </b>
<input type="text" name="name" class="pure-input" value="<?php echo $bowl_name ?>" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> ><br>
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
	if ($team1 == $team_id) {
	        $team_list = $team_list . "<option value=\"" . $team_id . "\" selected>" . $team_name . "</option> ";
	} else {
		$team_list = $team_list . "<option value=\"" . $team_id . "\">" . $team_name . "</option> ";
	}
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
        if ($team2 == $team_id) {
                $team_list = $team_list . "<option value=\"" . $team_id . "\" selected>" . $team_name . "</option> ";
        } else {
                $team_list = $team_list . "<option value=\"" . $team_id . "\">" . $team_name . "</option> ";
        }

} // <-- End of getting the team names and ids

} catch (PDOException $e) {
        //Do nothing yet
}

echo $team_list;

echo "</select>";
?>

<b> TV Network: </b>
<input type="text" name="network" class="pure-input" value="<?php echo $tv_network ?>" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> ><br>

<b> Bowl Type: </b>
<select class="pure-input" name="type" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> >
<option value="1" <?php if ($game_type == "1") { echo "selected"; } ?> >Standard</option> <option value ="2" <?php if ($game_type == "2") { echo "selected"; } ?> >New Year's Six</option> <option value ="3" <?php if ($game_type == "3") { echo "selected"; } ?> >Playoff</option> <option value ="4" <?php if ($game_type == "4") { echo "selected"; } ?> >Championship</option> </select> <br>

<b> Gametime: </b>
<input type="date" id="date" name="date" value="<?php echo substr($gametime, 0, 10) ?>">
<input type="time" id="gametime" name="gametime" value="<?php echo substr($gametime, -8, 5) ?>">
<br><br>

&nbsp;<button type="submit" value="Add" class="pure-button pure-button-primary" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> >Update Bowl</button>

</form>
