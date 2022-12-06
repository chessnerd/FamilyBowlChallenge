<?php
require_once("session.php");
$title = "Challenge Account Creation";
require_once("header.php");
?>

<h2>Challenge Account Creation</h2>
<p>This year, everything is online, including making picks.<br>
So that I know who is picking, I'll need people to set up accounts.</p>
<p>Below, you can enter your real name (so I know who you are),<br>
a player name (it can be just your name, or a fun one like "Hans" or "Sparky"),<br>
a username (for you to use later to manage your picks),<br>
a password (so that other people don't change your picks on you),<br>
and answer a simple security question.</p>

<?php
// If the user is already logged in, send them to the user page
if (isset($_SESSION['username'])) {
	header("Location: /BowlManager/userpage.php");
	exit;
}
if (isset($_GET['failed'])) {
	if ($_GET['failed'] == "bad_security") {
		echo "<p style=\"color:red\">Incorrect security question answer.</p>";
	} else if ($_GET['failed'] == "bad_database" || $_GET['failed'] == "unknown") {
		echo "<p style=\"color:red\">Server Error! Sorry, please try again later.</p>";
	} else if ($_GET['failed'] == "name_taken") {
		echo "<p style=\"color:red\">This username has already been taken.</p>";
	} else {
		echo "<p style=\"color:red\">Please enter all form data below.</p>";
	} // Give specific errors for what they are missing
}
?>

<form action="add_user.php" method="post" class="pure-form">

<b>Your Name:</b><br>
<input type="text" name="actual_name" class="pure-input" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> ><br>
<b>Player Name:</b><br>
<input type="text" name="player_name" class="pure-input" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> ><br>
<b>Username:</b><br>
<input type="text" name="username" class="pure-input" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> ><br>
<b>Password:</b><br>
<input type="password" name="password" class="pure-input" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> ><br>
<b>Alicia Kasen's maiden name?</b><br>
<input type="text" name="security" class="pure-input" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> ><br><br>
&nbsp;<button type="submit" value="Login" class="pure-button pure-button-primary" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> >Create Account</button>

</form>

<br><hr>

<?php
require_once("footer.php");
?>
