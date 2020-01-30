<?php

// Variables & Functions Declaration
$username = "system";
$password = "favian";
$connection_string = "//localhost:1521/XEPDB1";

function delete_guest($conn)
{

}

// Database Connection
$conn = oci_connect($username, $password, $connection_string);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Get All Guests
$stmt = oci_parse($conn, "SELECT * FROM GUEST_REGISTRATION;");
oci_execute($stmt);
$nrows = oci_fetch_all($stmt, $res);

if ($nrows > 0)
{
    $guest_list = array();

    foreach($res as $col)
    {
        // $dataA = [
        //     'guestId' => $col["personal_id"],
        //     'firstName' => $col["first_name"],
        //     'lastName' => $col["last_name"],
        //     'emailAddress' => $col["email_address"],
        //     'brand' => $col["brand"],
        //     'optedIn' => $col["email_list_flag"],
        //     'ship' => $col["ship"],
        //     'sailDate' => $col["sail_date"],
        //     'comments' => $col["comments"],
        //     'delete' => '<i class="fa fa-trash-o fa-lg" onclick="deleteGuest(this)"></i>'
        // ];
                $dataA = [
            $col["personal_id"],
            $col["first_name"],
            $col["last_name"],
            $col["email_address"],
            $col["brand"],
            $col["email_list_flag"],
            $col["ship"],
            $col["sail_date"],
            $col["comments"],
            '<i class="fa fa-trash-o fa-lg" onclick="deleteGuest(this)"></i>'
        ];
        $guest_list = array_push($dataA);
    }
    // echo json_encode($guest_list);  //Send back JSON array.
    echo $guest_list;
}

// Close Connection
oci_close($conn);
?>