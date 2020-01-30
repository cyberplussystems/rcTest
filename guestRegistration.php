<?php

// Variables & Functions Declaration
$username = "system";
$password = "favian";
$connection_string = "//localhost:1521/XEPDB1";

$personal_id = $_REQUEST["guestId"];
$first_name = $_REQUEST["firstName"];
$last_name = $_REQUEST["lastName"];
$email_address = $_REQUEST["emailAddress"];
$brand = $_REQUEST["brand"];
$email_list_flag = $_REQUEST["optedIn"];
$ship = $_REQUEST["ship"];
$sail_date = $_REQUEST["sailDate"];
$comments = $_REQUEST["comments"];

    function create_table($conn)
    {
        $schema = "CREATE TABLE GUEST_REGISTRATION (
            personal_id INT(7) UNSIGNED NOT NULL PRIMARY KEY,
            first_name VARCHAR(50) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            email_address VARCHAR(100) NOT NULL,
            brand VARCHAR(1) NOT NULL,
            email_list_flag NUMBER NOT NULL,
            ship varchar(100) NOT NULL,
            sail_date date NOT NULL,
            comments varchar(500)
            )";

        $qryString = "SELECT COUNT(*) FROM dba_tables where table_name = 'GUEST_REGISTRATION'";
        $is_created = oci_parse($conn, $qryString);
        oci_execute($is_created);
        $nrows = oci_fetch_all($is_created, $res);

        if ($nrows <= 0)
        {
            $stmt = oci_parse($conn, $schema);
            oci_execute($stmt);
        }
    }

    function validate_pin($conn)
    {
        $qryString = "SELECT personal_id FROM GUEST_REGISTRATION";
        $stmt = oci_parse($conn, $qryString);
        oci_execute($stmt);
        $nrows = oci_fetch_all($stmt, $res);

        foreach ($res as $item)
        {
            if ($item === $personal_id)
            {
                echo "User already exists.";
            }   
        }
    }

    function register_guest($conn)
    {
        $qryString = "INSERT INTO GUEST_REGISTRATION (personal_id, first_name, last_name, email_address, brand, email_list_flag, ship, sail_date, comments)
        VALUES ($personal_id, $first_name, $last_name, $email_address, $brand, $email_list_flag, $ship, $sail_date, $comments);";
        $stmt = oci_parse($conn, $qryString);
        oci_execute($stmt);
    }

// Database Connection
$conn = oci_connect($username, $password, $connection_string);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Table Creation (if needed)
create_table($conn);

// PIN Validation
validate_pin($conn);

// New Guest Registration
register_guest($conn);

// Close Connection
oci_close($conn);
?>
