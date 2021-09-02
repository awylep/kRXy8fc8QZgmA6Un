<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once("config.php");
    $postdata = file_get_contents("php://input");

    if (isset($postdata)) {
        $request1 = json_decode($postdata);
        $username = $request1->username;
        $nama = $request1->nama;
        $instansi = $request1->instansi;
        $alamat = $request1->alamat;
        $email = $request1->email;
        $password = $request1->password;
        $token = $request1->token;
        if ($username == '' || $nama == '' || $instansi == '' || $alamat == '' || $email == '' || $password == '') {
            echo json_encode(array("status" => "false", "message" => "Parameter missing!"));
        } else {
            $query = "SELECT * FROM user WHERE username='$username'";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {
                echo json_encode(array("status" => "false", "message" => "NIK already exist!"));
            } else {
                $query = "INSERT INTO users (username, nama, instansi, alamat, email, password, notif_token) VALUES ('$username', '$nama', '$instansi', '$alamat', '$email', '$password', '$token')";
                if (mysqli_query($con, $query)) {
                    $query = "SELECT * FROM user WHERE username='$username'";
                    $result = mysqli_query($con, $query);
                    $emparray = [];
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $emparray[] = $row;
                            echo json_encode(array("status" => "true", "message" => "Successfully registered!", "data" => $row));
                        }
                    }
                } else {
                    echo json_encode(array("status" => "false", "message" => "Error occured, please try again!"));
                }
            }
            mysqli_close($con);
        }
    }
} else {
    echo json_encode(array("status" => "false", "message" => "Error occured, please try again!"));
}
