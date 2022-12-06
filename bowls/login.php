<?php
require_once("session.php"); // We need session data on this page

// If the user is already logged in, send them to the user page instead
if (isset($_SESSION['username'])) {
	header("Location: userpage.php");
	exit;
}

// If we make it this far, we'll want a header
$title = "Bowl Challenge Login";
require_once("header.php");
?>

<h2 <?php if($mobile) { echo "style=\"font-size:400%\"";} ?> >Bowl Challenge Login</h2>

<?php
// Check to see if this was a failed login. If so, tell the user that's what happened.
if (isset($_GET['login_failed'])) {
	echo "<p style=\"color:red\">Incorrect username or password, please try again</p>";
} else {
	echo "<br><br>";
}
?>

<form action="auth.php" method="post" class="pure-form">
<b <?php if($mobile) { echo "style=\"font-size:200%\"";} ?> >Username:</b><br>

<?php
// If the username get is set, then put the username in the field for them
if (isset($_GET['username'])) {
	echo "<input type=\"text\" name = \"username\" value = \"" . $_GET['username'] . "\"";
	if($mobile) { echo "style=\"font-size:200%\"";}
	echo ">";
} else {
	echo "<input type=\"text\" name = \"username\"";
	if($mobile) { echo "style=\"font-size:200%\"";}
	echo ">";
}
?>

<br>
<b <?php if($mobile) { echo "style=\"font-size:200%\"";} ?> >Password:</b><br>
<input type="password" name="password" <?php if($mobile) { echo "style=\"font-size:200%\"";} ?> ><br><br>
&nbsp;<button type="submit" value="Login" class="pure-button pure-button-primary" <?php if($mobile) { echo "style=\"font-size:200%\"";} ?> >Login</button>

</form>

<?php if($mobile) { echo "<br><br>";} ?>

<br><hr>
<?php require_once("footer.php"); ?>
