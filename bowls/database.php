<?php

$servername = "localhost";
$username = "jason";
$password = "kosumi";

$conn = "";

try {
        $conn = new PDO("mysql:host=$servername;dbname=BowlManager", $username, $password);
        // Set PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
	$conn = "Connection failed";
}

?>
