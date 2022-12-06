<?php
require_once("database.php");

try {

$stmt = $conn->query("SELECT * FROM Players");
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $conn->query("SELECT * FROM Picks");
$picks = $stmt->fetchAll(PDO::FETCH_ASSOC);

$playerScores = array();

foreach($players as $player) {
	$playerScores[$player['id']] = 0;
}

foreach($picks as $pick) {
	$stmt = $conn->query("SELECT winner FROM Bowls WHERE id=" . $pick['bowl']);
	$bowl = $stmt->fetch(PDO::FETCH_NUM);
	if ( count($bowl) > 0 && $pick['team_pick'] == $bowl[0]) {
		$stmt = $conn->query("SELECT game_type FROM Bowls WHERE id=" . $pick['bowl']);
        	$bowl = $stmt->fetch(PDO::FETCH_NUM);
		$game_type = $bowl[0];
		$pid = $pick['player'];
		if ($game_type == 4) {
			$playerScores[$pid] += 2000;
		} else if ($game_type == 3) {
                        $playerScores[$pid] += 1500;
                } else if ($game_type == 2) {
                        $playerScores[$pid] += 1000;
                } else {
                        $playerScores[$pid] += 500;
                }
	}
}

foreach($playerScores as $id => $score) {
	$stmt = $conn->prepare("UPDATE Players SET score=" . $score .  " WHERE id=" . $id);
	$stmt->execute();
}

$sorted_players = array();

$stmt = $conn->query("SELECT * FROM Players ORDER BY score DESC, player_name ASC");
$sorted_players = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<b style=\"font-size:150%\"><u>Current Standings</u><br>";
foreach($sorted_players as $player) {
	echo $player['player_name'] . " " . $playerScores[$player['id']] . "<br>";
}

} catch (PDOException $e) {
	//Do nothing yet
}

?>

</b>
