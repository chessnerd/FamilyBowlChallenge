<?php
require_once("session.php"); // We need the session...
session_destroy(); // To end the session.
header ("Location: index.php"); // Send the user back to the main page
?>
