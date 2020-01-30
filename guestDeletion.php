<?php

// Variables & Functions Declaration
$username = "system";
$password = "favian";
$connection_string = "//localhost:1521/XEPDB1";

$personal_id = $_REQUEST["guestId"];

function delete_guest($conn)
{

}

// Database Connection
$conn = oci_connect($username, $password, $connection_string);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Delete Guest
$stmt = oci_parse($conn, "DELETE FROM GUEST_REGISTRATION WHERE personal_id=$personal_id");
oci_execute($stmt);

if ($conn->query($stmt) === TRUE) {
    echo "Guest deleted successfully";
} else {
    echo "Error deleting guest: " . $conn->error;
}

// Close Connection
oci_close($conn);
?>
