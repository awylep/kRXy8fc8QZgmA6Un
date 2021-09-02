<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once("config.php");
    $postdata = file_get_contents("php://input");
    if (isset($postdata)) {
        $request1 = json_decode($postdata);
        $username = $request1->username;
        $password = $request1->password;
        if ($username == '' || $password == '') {
            echo json_encode(array("status" => false, "message" => "Parameter missing!"));
        } else {
            $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
            $result = mysqli_query($con, $query);
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $emparray = $row;
                    }
                }
                echo json_encode(array("status" => true, "message" => "Login successfully!", "data" => $emparray));
            } else {
                echo json_encode(array("status" => false, "message" => "Invalid NIK or password!"));
            }
            mysqli_close($con);
        }
    }
} else {
    echo json_encode(array("status" => false, "message" => "Error occured, please try again!"));
}
