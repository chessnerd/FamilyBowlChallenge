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
$title = "Update Bowls";
require_once("header.php");


// Prepare to use the database
require_once("database.php");
?>

<h2>Current Bowl Games</h2>

<?php
// See if we are coming here from updating a bowl
// If so, see if there was an error; report it if there was
if (isset($_GET['bowl_updated'])) {
        if ($_GET['bowl_updated'] == "false") {
                echo "<p style=\"color:red\"><b>Error! Bowl was not updated!</b></p>";
        }
}
?>

<!--We will be using a form for this-->
<script>
        function formSubmit() {
                document.forms["new"].submit();
        }
</script>

<!--And that form will take the form of a table of dropdowns-->
<form action="update_bowl_form.php" id="update_bowl" method="get" class="pure-form pure-form-stacked">
<table>


<?php
// Build the table!
try {
// Get the bowls in order of gametime
$stmt = $conn->query("SELECT * FROM Bowls ORDER BY gametime ASC");
$count = 0;
// Construct the table row by row
foreach( $stmt->fetchAll(PDO::FETCH_ASSOC) as $row ) {
        if ($count == 0) {
                echo "<tr>";
        }

        $bowl_name = $row['name'];
        $bowl_id = $row['id'];
	$gametime = $row['gametime'];
	$network = $row['tv_network'];

        // Get the team names
        $team_stmt = $conn->query("SELECT * FROM Teams WHERE id=" . $row['team1']);
        $team_name = $team_stmt->fetch(PDO::FETCH_ASSOC);
        $team1 = $team_name['name'];

        $team_stmt = $conn->query("SELECT * FROM Teams WHERE id=" . $row['team2']);
        $team_name = $team_stmt->fetch(PDO::FETCH_ASSOC);
        $team2 = $team_name['name'];

        // Color in every other cell
        $tdvalues = "";
        if ($count % 2 == 0) {
                $tdvalues = " bgcolor=#CFECEC";
        }

        // Bold the team name and, if we are on a mobile device, up the font size
        echo "<td" . $tdvalues . "> <b";
        if($mobile) { echo " style=\"font-size:150%\""; }
        echo ">$bowl_name</b> <br>"; echo date_format(date_create($gametime), "M j, Y g:i A"); echo " on $network<br>$team1 vs. $team2";
	echo "<br><button type=\"submit\" name=\"id\" value=\"$bowl_id\" form=\"update_bowl\" class=\"pure-button pure-button-primary\""; if($mobile) { echo "style=\"font-size:200%\"";} echo ">Update Bowl</button></td>";
	$count = $count + 1;

        // Only put 4 teams in each row
        // For those non-CS people, we start counting at 0...
        if ($count > 3) {
                echo "</tr>";
                $count = 0;
        }
} // <-- End of putting games into the table

// If we didn't close the last table row earlier, close it now
if ($count != 0) {
        echo "</tr>";
}

} catch (PDOException $e) {
        //Do nothing yet
}
?>

<!--Close close the table, add the save button, and end the form-->
</table>
</form>

<form action="new_bowl_form.php" id="new_bowl" method="post" class="pure-form pure-form-stacked">
<br><button type="submit" form="new_bowl" class="pure-button pure-button-primary" <?php if($mobile) { echo "style=\"font-size:200%\"";} ?> >Add New Bowl</button>
</form>

<br><hr>
<?php
require_once("footer.php");
?>

