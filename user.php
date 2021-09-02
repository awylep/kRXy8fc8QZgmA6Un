<?php

$link=mysql_connect("localhost","root","");
mysql_select_db("visitordb",$link);

class User
{

private $db;
private $db_table = "user";

public function isLoginExist($username, $password){		
			
	$query = "select * from " . $this->db_table . " where username = '$username' AND password = '$password' Limit 1";
	$row=mysql_query($query);
    $data=mysql_fetch_array($row);
	
	if($data>0)
        {
          	return true;
       	}
       	else
        {
			return false;
        }		
}

public function createNewRegisterUser($username,$nama,$instansi,$alamat,$email, $password){
		
	$query = "insert into user (username, nama, instansi, alamat, email, password, created_at, updated_at) values ('$username', '$nama', '$instansi', '$alamat', '$email', '$password')";
	
	$row=mysql_query($query);
	if($row>0)
        {
          	$json['success'] = 1;	
       	}
       	else
        {
			$json['success'] = 0;
        }
	return $json;
}

public function loginUsers($username, $password){
		
	$json = array();
	$canUserLogin = $this->isLoginExist($username, $password);
	if($canUserLogin){
		$json['success'] = 1;
	}else{
		$json['success'] = 0;
	}
	return $json;
}
}
?>
