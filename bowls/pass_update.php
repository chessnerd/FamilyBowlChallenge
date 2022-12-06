<?php
require_once("session.php");
require_once("database.php");

$user = "";
$new_pass = "";
$pass = "";

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit;
} // else
$user = $_SESSION['username'];

if (isset($_POST['new_pass']) && trim($_POST['new_pass']) != "") {
        $new_pass = password_hash($_POST['new_pass'], PASSWORD_BCRYPT);
} else {
        header("Location: change_pass.php?failed=no_password");
        exit;
}


// Create connection and enter data
try {
	$verify = $conn->prepare("SELECT password from Players where username='" . $user . "'");
        $verify->execute();
        $row = $verify->fetch(PDO::FETCH_ASSOC);
        $pass = password_verify($_POST['cur_pass'], $row["password"]);

        if ($pass) {
                // PASSWORDS MATCH! Keep going!
        } else {
                header("Location: change_pass.php?failed=wrong_pass");
                exit;
        }

        $sql = "UPDATE Players SET password='" . $new_pass . "' WHERE username='" . $user . "'";
        $statement = $conn->prepare($sql);
        $success = $statement->execute();
        if ($success) {
                header("Location: userpage.php?update_password=true");
                exit;
        } //else { Do nothing }
} catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
        //header("Location: userpage.php?update_password=bad_database");
        exit;
}

header("Location: userpage.php?update_password=failed-unknown");
?>

