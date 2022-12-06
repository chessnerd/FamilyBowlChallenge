<?php
require_once("session.php");

if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
}

$title = "Change " . $_SESSION['playerName'] . "'s Password";
require_once("header.php");

$error = 0;
if (isset($_GET['failed'])) {
	if ($_GET['failed']=="wrong_pass") {
		$error = 1;
	} else {
		$error = 2;
	}
}
?>

<h2 <?php if($mobile) { echo "style=\"font-size:400%\"";} ?> >Change Password</h2>

<?php
if ($error == 1) {
	echo "<p style=\"color:red\"><b>Incorrect Password Given!</b></p>";
} else if ($error == 2) {
	echo "<p style=\"color:red\"><b>No new password entered.</b></p>";
}
?>

<form action="pass_update.php" method="post" class="pure-form">

<b>Current Password:</b><br>
<input type="password" name="cur_pass" class="pure-input" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> ><br>
<b>New Password:</b><br>
<input type="password" name="new_pass" class="pure-input" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> ><br>
&nbsp;<button type="submit" value="Password" class="pure-button pure-button-primary" <?php if ($mobile){ echo "style=\"font-size:200%\""; } ?> >Change Password</button>

</form>

<br><hr>
<?php require_once("footer.php"); ?>

