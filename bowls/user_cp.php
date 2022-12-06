<?php
require_once("session.php");
require_once("database.php");
require_once("time_settings.php");

$admin_status = false;
$stmt = $conn->query("SELECT admin FROM Players where id=" . $_SESSION['player_id']);
$admin = $stmt->fetch(PDO::FETCH_NUM);
if ($admin[0]) {
	$admin_status = true;
}
?>

<div id="outer">
        <script>
                function formSubmit() {
                        document.forms["new"].submit();
                }
        </script>

	<?php if ($admin_status && strtotime("now") < strtotime($first_game_kickoff_time)) { ?>
        <div class="inner">
                <form action="update_bowls.php" id="update_bowls">
                        <button type="submit" form="update_bowls" class="pure-button pure-button-primary" <?php if($mobile) { echo "style=\"font-size:140%\"";} ?> >Update Bowl Info</button>&nbsp;&nbsp;
                </form>
        </div>
        <?php } ?>
	<?php if ($admin_status && strtotime("now") > strtotime($first_game_kickoff_time)) { ?>
        <div class="inner">
		<form action="admin_cp.php" id="update">
			<button type="submit" form="update" class="pure-button pure-button-primary" <?php if($mobile) { echo "style=\"font-size:140%\"";} ?> >Update Winners</button>&nbsp;&nbsp;
		</form>
	</div>
	<?php } ?>

	<div class="inner">
	        <form action="change_pass.php" id="password">
			<button type="submit" form="password" class="pure-button pure-button-primary" <?php if($mobile) { echo "style=\"font-size:140%\"";} ?> >Change Password</button>&nbsp;&nbsp;
		</form>
	</div>
	<?php if (strtotime("now") > strtotime($first_game_kickoff_time)) { ?>
        <div class="inner">
		<form action="current.php" id="standings">
			<button type="submit" form="standings" class="pure-button pure-button-primary" <?php if($mobile) { echo "style=\"font-size:140%\"";} ?> >View Standings</button>&nbsp;&nbsp;
		</form>
	</div>
	<?php } ?>
	<div class="inner">
		<form action="logout.php" id="logout">
			<button type="submit" form="logout" class="pure-button pure-button-primary" <?php if($mobile) { echo "style=\"font-size:140%\"";} ?>>Logout</button>
		</form>
	</div>
</div>

