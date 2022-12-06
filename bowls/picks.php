<?php
require_once("session.php");
require_once("database.php");
require_once("time_settings.php");
//<link rel="stylesheet" type="text/css" href="manager_style.css">
?>

<p>From this page you can make all of your picks. When you are satisified, you can save them.<br>
You can pick just a few games for now, or all of them at once, and even come back to change them later!<br>
You have until the first game kicks off on <?php echo(date('l, F jS', strtotime($first_game_kickoff_time))) ?> to choose.<br><br>
This year each correct pick for regular bowls is worth 500 points.<br>
The New Year's Six are each worth 1,000 points, with the two playoff games worth 1,500 points.<br>
The National Championship Game is 2,000 points. <br><br>
<b>Choose wisely, randomly, however you want!</b><br><br>
Games you haven't picked are highlighted in <b style="color:blue">blue</b>.<br> Don't forget to hit "Save Picks" down at the bottom.<br></p>

<script>
	function formSubmit() {
		document.forms["new"].submit();
	}
</script>

<form action="submit_picks.php" id="picking" method="get" class="pure-form pure-form-stacked">

<table>

<?php

try {

$stmt = $conn->query("SELECT * FROM Bowls ORDER BY gametime ASC");
$count = 0;
foreach( $stmt->fetchAll(PDO::FETCH_ASSOC) as $row ) {
	if ($count == 0) {
		echo "<tr>";
	}

	$bowl_name = $row['name'];
	$bowl_id = $row['id'];
	// Get the team names
	$team_stmt = $conn->query("SELECT * FROM Teams WHERE id=" . $row['team1']);
	$team_name = $team_stmt->fetch(PDO::FETCH_ASSOC);
	$team1 = $team_name['name'];

	$team_stmt = $conn->query("SELECT * FROM Teams WHERE id=" . $row['team2']);
	$team_name = $team_stmt->fetch(PDO::FETCH_ASSOC);
	$team2 = $team_name['name'];

//	$team2 = $conn->query("SELECT * FROM Teams WHERE id=" . $row['team2'])->fetch(PDO::FETCH_ASSOC)['name'];

	$select1 = "";
	$select2 = "";
	$no_selection = false;

	$selection = $conn->query("SELECT team_pick FROM Picks WHERE player=" . $_SESSION['player_id'] . " AND bowl=" . $row['id']);
	$select_num = $selection->fetch(PDO::FETCH_ASSOC);
	if ($select_num['team_pick'] == 1) {
		$select1 = "selected=\"selected\"";
	} else if ($select_num['team_pick'] == 2) {
		$select2 = "selected=\"selected\"";
	} else {
		$no_selection = true;
	}

	$tdvalues = "";
	if ($count % 2 == 0) {
		$tdvalues = " bgcolor=#CFECEC";
	}

	echo "<td" . $tdvalues . "> <b ";
	if ($no_selection && $mobile) { echo "style=\"color:blue; font-size:150%\"";}
	else if ($no_selection) { echo "style=\"color:blue\""; }
	else if ($mobile) { echo "style=\"font-size:150%\""; }
	echo ">$bowl_name</b> <br> <select name=\"bowl" . $bowl_id . "\" form=\"picking\" class=\"pure-input\"";
	if($mobile) { echo "style=\"font-size:160%\"";}
	echo "> <option value=\"0\">Select Team</option> <option value=\"1\" " . $select1 . ">$team1</option> <option value=\"2\" " . $select2 . ">$team2</option> </select> </td>";
	$count = $count + 1;
	if ($count > 3) {
		echo "</tr>";
		$count = 0;
	}
}

} catch (PDOException $e) {
	//Do nothing yet
	//echo $e->getMessage();
}

?>

</tr>

</table>
<br><button type="submit" form="picking" class="pure-button pure-button-primary" <?php if($mobile) { echo "style=\"font-size:200%\"";} ?> >Save Picks</button>
</form>
