<?php
include "connection.php";
$day = $_POST['day'];
$period = $_POST['period'];
$query = mysqli_query($conn,"INSERT INTO `schedule_tb`(`days`, `periods`) VALUES ('$day','$period')");

if ($query) {
	$response['message'] = true;
}
else{
	$response['message'] = false;
}
echo json_encode($response);
?>