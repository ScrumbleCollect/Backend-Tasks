<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['userName']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$userName = validate($_POST['userName']);
	$pass = validate($_POST['password']);
	if (empty($userName)) {
		header("Location: index.php?error=User Name is required");
	    exit();
	}else if(empty($pass)){
        header("Location: index.php?error=Password is required");
	    exit();
	}else{
		$sql = "SELECT * FROM users WHERE user_name='$userName'";

		$result = mysqli_query($conn, $sql);

		foreach ($result as $row) {{
            if ($row['user_name'] === $userName && password_verify($pass, $row['password'])) {
            	$_SESSION['user_name'] = $row['user_name'];
            	$_SESSION['id'] = $row['id'];
            	header("Location: home.php");
		        exit();
            }else{
				header("Location: index.php?error=Incorrect username or password");
		        exit();
			}
		}
	}
	
}}
else{
	header("Location: index.php");
	exit();
}
?>