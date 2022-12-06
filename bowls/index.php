<?php
require_once("session.php");
$title = "Family Bowl Challenge";
$mobile = false;
require_once("time_settings.php");
require_once("header.php");
?>

<div id="wrapper">

<head>
<link rel="stylesheet" type="text/css" href="manager_style.css">
</head>

<h2 <?php if ($mobile){ echo "style=\"font-size:450%\""; } ?> >Welcome to the <?php echo $current_year; if ($mobile){ echo "<br>"; } ?>  Bowl Challenge!</h2>

<IMG SRC="FamilyBowlChallenge<?php if ($mobile){ echo "Logo"; } ?>.png" ALT="Family Bowl Challenge Classic" TITLE="Family Bowl Challenge Classic" WIDTH=400 HEIGHT=280>

<p <?php if ($mobile){ echo "style=\"font-size:26px\""; } ?> >

<br><b>We're celebrating 15 years of the annual Bowl Challenge!</b><br><br>As with the last several years, the Challenge Manager is entirely online!<br>
You're able to enter picks, analyze your chances, <?php if ($mobile){ echo "<br>"; } ?> and keep up with games as easily as ever.<br></p>
<br>

<div id="outer">
	<script>
		function formSubmit() {
			document.forms["new"].submit();
		}
	</script>

	<?php if (!isset($_SESSION['username']) && strtotime("now") < strtotime($first_game_kickoff_time)) { ?>
                <div class="inner">
			<form action="new_user.php" id="new">
                                <button type="submit" form="new" class="pure-button pure-button-primary" <?php if($mobile) { echo "style=\"font-size:200%\"";} ?> >Create New Account</button>&nbsp;&nbsp;
                        </form>
                </div>
        <?php } ?>

        <div class="inner">
                <form action="login.php" id="login">
                        <button type="submit" form="login" class="pure-button pure-button-primary" <?php if($mobile) { echo "style=\"font-size:200%\"";} ?>> 
			<?php if (!isset($_SESSION['username'])) {
				echo "Login to Manage Picks";
			} else if (strtotime("now") > strtotime($first_game_kickoff_time)) {
				echo "Manage Account";
			} else {
				echo "Manage Picks";
			} ?>
			</button>&nbsp;&nbsp;
                </form>
        </div>

        <?php if (strtotime("now") > strtotime($first_game_kickoff_time)) { ?>
                <div class="inner">
                        <form action="current.php" id="standings">
                                <button type="submit" form="standings" class="pure-button pure-button-primary" <?php if($mobile) { echo "style=\"font-size:200%\"";} ?> >View Standings</button>
                        </form>
                </div>
        <?php } ?>

</div>
<br><br><br>
<p  <?php if ($mobile){ echo "style=\"font-size:22px\""; }else{ "style=\"font-size:11px\"";} ?> >(To look at results from previous years, <a href="archives/index.html">click here</a>).</p>
<br><br>
<?php require_once("footer.php"); ?>

</div>

</body>
</html>
