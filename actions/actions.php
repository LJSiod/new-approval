<?php

include('../config/db.php');


if (isset($_GET['id'])) {
	$action = $_GET['action'];
	$id = $_GET['id'];
	$username = $_GET['username'];
	$password = $_GET['password'];

	switch ($action) {
		case 'disapprove':
			$sql = "UPDATE `ApprovalInfo` SET `Status`= 'REJECTED' WHERE ID= $id";
			break;
		case 'username':
			$sql = "UPDATE useraccount SET Username = '$username' WHERE id = $id";
			break;
		case 'password':
			$sql = "UPDATE useraccount SET Password = '$password' WHERE id = $id";
			break;
		default:
			echo "Invalid action";
			break;
	}

	$stmt = $conn->prepare($sql);
	$stmt->execute();

	header("Location: ../views/dashboard.php");
	exit;
}


?>