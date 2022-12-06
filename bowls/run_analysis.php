<?php
require_once("session.php");
if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
}

$name = $_SESSION['playerName'];

$title = "Analysis for " . $name;
require_once("header.php");

$username = $_SESSION['username'];
$pid = $_SESSION['player_id'];
$best_scores = array();
$worst_scores = array();

require_once("database.php");

echo "<h2>Analysis for " . $name . "</h2>";

echo "\n<p>Below are your best and worst cases for the remainder of the challenge.<br>";
echo "Best case assumes you picked all remaining games correctly. <br> Worst case assumes, well, the opposite.";
echo "</p><br>";

try {
// Get all the players
$stmt = $conn->query("SELECT id, player_name, score from Players ORDER BY player_name ASC");
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get all the player's picks
$stmt = $conn->query("SELECT * FROM Picks WHERE player=" . $pid);
$picks = $stmt->fetchAll(PDO::FETCH_ASSOC);
$winners = array();
$losers = array();

// Get the rest of the picks
$stmt = $conn->query("SELECT * FROM Picks");
$other_picks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Now get the bowls and narrow that down to all the bowls not finished
$stmt = $conn->query("SELECT id, winner, game_type from Bowls ORDER BY gametime DESC");
$bowls = $stmt->fetchAll(PDO::FETCH_ASSOC);

$completed = array();
$bowl_worth = array();

foreach ($bowls as $bowl) {
	if ($bowl['winner'] != 0) {
		$completed[] = $bowl['id'];
	} else {
		$bowl_worth[$bowl['id']] = $bowl['game_type'] * 500;
	}
}

// Get all the current scores
foreach ($players as $player) {
        $best_scores[$player['player_name']] = 0 + $player['score'];
        $worst_scores[$player['player_name']] = 0 + $player['score'];
}

// Figure out who the player wants to win
foreach ($picks as $pick) {
	if ($pick['team_pick'] == 2) {
		$winners[$pick['bowl']] = 2;
		$losers[$pick['bowl']] = 1;
	} else {
		$winners[$pick['bowl']] = 1;
		$losers[$pick['bowl']] = 2;
	}
}

foreach ($other_picks as $pick) {
	// If the game is over, don't worry about it
	if (in_array($pick['bowl'], $completed)) {
		continue;
	}
	if ($pick['team_pick'] == $winners[$pick['bowl']]) {
		$stmt = $conn->query("SELECT player_name FROM Players WHERE id=" . $pick['player']);
		$player = $stmt->fetch(PDO::FETCH_ASSOC);
		$best_scores[$player['player_name']] += $bowl_worth[$pick['bowl']];
	} else if ($pick['team_pick'] == $losers[$pick['bowl']]) {
		$stmt = $conn->query("SELECT player_name FROM Players WHERE id=" . $pick['player']);
                $player = $stmt->fetch(PDO::FETCH_ASSOC);
                $worst_scores[$player['player_name']] += $bowl_worth[$pick['bowl']];
	}
}

arsort($best_scores);
arsort($worst_scores);

echo "<table><tr><th bgcolor=#CEFCFC><b><u>Best Case</b></u></th>";
echo "<th bgcolor=#4E8C8C><b><u>Worst Case</b></u></th></tr><tr><td bgcolor=#CEFCFC>";
foreach ($best_scores as $player => $score) {
	if ($player == $name) { echo "<b>"; }
        echo $player . " " . $score . "<br>";
        if ($player == $name) { echo "</b>"; }
        echo "\n";
}
echo "</td><td bgcolor=#4E8C8C>";

foreach ($worst_scores as $player => $score) {
        if ($player == $name) { echo "<b>"; }
        echo $player . " " . $score . "<br>";
        if ($player == $name) { echo "</b>"; }
        echo "\n";
}
echo "</td></tr></table>\n";

} catch (PDOException $e) {
        //Do nothing yet
}
echo "<br>";
echo "<form action=\"userpage.php\"><button type=\"submit\" class=\"pure-button pure-button-primary\">Return to User Page</button></form>";

echo "<br><hr>";
require_once("footer.php");
?>
