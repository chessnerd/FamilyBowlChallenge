<?php
// We want this page to have the header and it needs database access
require_once("header.php");
require_once("database.php");
require_once("time_settings.php");
?>

<h2>College Football Bowl Challenge <?php echo $current_year; ?></h2>
<?php
// If the challenge hasn't started yet, then there should be no reason to look here
if (strtotime("now") < strtotime($first_game_kickoff_time)) {
?>
<p><b>Uh... the games haven't started yet. <br>Why are you looking for standings?</b></p>

<?php
// If the challenge is under way, then print all the tables and stuff!
} else { ?>
<hr>
<font size=4>
It's time again for our annual college football bowl challenge!
<br>
</font>

<font size=2>
(To look at results from prevoius years, <a href="archives/index.html">click here</a>).
</font><br><br>
<font size=3>
This year each correct pick for regular bowls is worth 500 points.
<br>
The New Year's Six are each worth 1,000 points, with the two playoff games worth 1,500 points.
<br>
The National Championship Game is 2,000 points.
<br><br>
Completed games and the winning teams are shown in <b>bold</b>.
</font>
<br><br><font size=2><i>
Standings updated on 

<?php
$stmt = $conn->query("SELECT update_time FROM information_schema.tables WHERE table_schema='BowlManager' AND table_name='Bowls'");
$time = $stmt->fetch(PDO::FETCH_ASSOC);
$counter = 0;
foreach ($time as $datetime) {
	if ($counter < 1) {
		echo "" . date("D M j h:i:s T Y", strtotime($datetime));
		$counter++;
	}
}

// Just get the current time...
//echo "" . date("D M j h:i:s T Y");
?>

</i></font>
<br><br>
<?php
// Put the standings at this point on the page
require_once("standings.php");
?>
<br><br>
<?php
/**
 * This function creates a table for the games with player names across the top
 *
 * @param title the title of the table
 * @param color the primary color of the table
 * @param gametypes which games to include in the table
 * @param withBottom whether or not there should be a bottom row of player names
 */
function makeTable($title, $color, $gametypes, $withBottom) {

require("database.php");

$bgcolor = "bgcolor=#95B9C7";
$color1 = "bgcolor=" . $color;
$color2 = "bgcolor=#FFFFFF";
$color = $color1;

$bwidth = "";

// Open the table
echo "<table>\n";

// Start the first row with the title
echo "<tr>\n";
echo "<th " . $color . " " . $bwidth . ">" . $title . "</th>\n";

// We need to be able to get the player names outside of the try/catch block
$player_names = array();
$player_ids = array();

try {
// Get the players in alphabetical order
$stmt = $conn->query("SELECT * FROM Players ORDER BY player_name ASC");
$count = 0;

// Create the top row by adding the player names
foreach( $stmt->fetchAll(PDO::FETCH_ASSOC) as $row ) {
        if ($count % 2 != 0) {
                echo "<th " . $color1 . ">";
        } else {
                echo "<th>";
        }

	// Collect the player names and ids for later use
        $player_names[] = $row['player_name'];
        $player_ids[] = $row['id'];

	// Print out the player names
        echo $player_names[$count];
        echo "</th>";
        $count = $count + 1;
}
echo "</tr>"; // End of top row


// Build the query for getting bowls based on game type
$query = "SELECT * FROM Bowls WHERE game_type=";

$count = 1;
foreach( $gametypes as $type ) {
	$query = $query . $type;
	// Add additional gametypes if needed
	if ($count < count($gametypes)) {
		$query = $query . " OR game_type=";
		$count = $count + 1;
	}
}

// Sort the games based on gametime
$stmt2 = $conn->query($query . " ORDER BY gametime ASC");
$count = 0;
$winner = 0;

// Build all the rows for the games
foreach( $stmt2->fetchAll(PDO::FETCH_ASSOC) as $row ) {
	// If the game has a winner, that means it's over
	if ($row['winner'] > 0) {
		$winner = $row['winner'];
	}
	echo "<tr><td " . $color1 . ">";

	// Give the bowl's name
	// Completed games are shown in bold
	if ($winner > 0) {
		echo "<b>" . $row['name'];
	} else {
		echo $row['name'];
	}

	// After the name of the bowl, show the time
	echo "<br>";
	$kickoff = "";
	$starttime = strtotime($row['gametime']);
	$kickoff = date("M j \a\\t g:i A", $starttime);
	echo $kickoff;

	// Now show what network the game is on
	echo "<br>on ";
	echo $row['tv_network'];
	if ($winner > 0) {
		echo "</b>";
	}
	echo "</td>\n";

	// Give every player's pick
	foreach ( $player_ids as $col ) {
		$correct = false; // Assume they are wrong
		echo "<td ";
		if ($count % 2 != 0) {
			echo $color1;
		} // else Do nothing, let the background be white
		echo ">";
		$playerPick = "";
		$stmt3 = $conn->query("SELECT team_pick FROM Picks WHERE player=" . $col . " AND bowl=" . $row['id']);
		$pick = $stmt3->fetch(PDO::FETCH_NUM);

		// Make sure the player actually made a pick before checking it
		if (!empty($pick)) {
			// Check to see if they picked the right team before we get the team name
			if (($winner == 1 && $pick[0] == 1) || ($winner == 2 && $pick[0] == 2)) {
				$correct = true;
			}
			$team_pick = 0;
			if ($pick[0] == 1) {
				$team_pick = $row['team1'];
			} else {
				$team_pick = $row['team2'];
			}
			$stmt3 = $conn->query("SELECT name FROM Teams WHERE id=" . $team_pick);
			$pick = $stmt3->fetch(PDO::FETCH_NUM);
			$playerPick = $pick[0];
		}

		// If they picked the right team, bold their pick
		if ($correct) {
                	echo "<b>" . $playerPick . "</b>";
		} else {
			echo $playerPick;
		}

		// On to the next player
		echo "</td>";
		$count = $count + 1;
	}

	// On to the next game
	echo "</tr>";
	$count = 0;
	$winner = 0;

} // <-- End of game row building

} catch (PDOException $e) {
	//Do nothing yet
}

// If the table is supposed to have a bottom row of players, make one
if ($withBottom) {
	// Start the row with the title
	echo "<tr><th " . $color1 . ">" . $title . "</th>";
	$count = 0;

	// Put in the player names
	foreach( $player_names as $footer ) {
        	if ($count % 2 != 0) {
                	echo "<th " . $color1 . ">";
        	} else {
                	echo "<th>";
        	}
        	echo $footer;
        	echo "</th>";
        	$count = $count + 1;
	}

	// Finish the last row
	echo "</tr>";
}

// The table is complete
echo "</table>";

} // <-- End of makeTable function

// Now that we defined that function, actually add the tables to the page!

// After the playoff games should be over, add the national championship game at the top
date_default_timezone_set("America/Detroit");
if (strtotime("now") > strtotime($day_after_playoff_games)) {
	makeTable("National Championship", "#FFCCCC", array(4), false);
        echo "<br><br>";
}

// First put in the New Year's Six table
makeTable("New Year's Six", "#E0FFFF", array(2, 3), false);
echo "<br><br>";
// Then put in the rest of the games
makeTable("Bowl Games", "#CFECEC", array(1), true);

} // <-- End of "else" statement from the beginning
?>

<br><hr>
<?php require_once("footer.php"); ?>
