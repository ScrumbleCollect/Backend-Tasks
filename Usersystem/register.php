<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {

           $userName = $_POST["user_name"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
		   $passwordHash = password_hash($password, PASSWORD_DEFAULT);
           $errors = array();
           
           if (empty($userName) OR empty($password) OR empty($passwordRepeat)) {
            array_push($errors,"All fields are required");
           }
           if ($password !== $passwordRepeat) {
            array_push($errors,"Password does not match");
           }

		   //check if username exists
           require_once "db_conn.php";
           $sql = "SELECT * FROM users WHERE user_name = '$userName'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"User already exists!");
           }
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }else{

		// prepare id for user from current max id
           $sql = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
		   
           $result = mysqli_query($conn, $sql);
		   $rowcount=mysqli_num_rows($result);
		   if ($rowcount == 0){
				$id = 1;
		   }
		   else{
				$id = (int)mysqli_fetch_array($result)[0] + 1;
		   }
		   
		   

		   //insert new user into database
            $sql = "INSERT INTO users (id, user_name, password) VALUES ( ?, ?, ? )";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt, "iss", $id, $userName, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
				
            }else{
                die("Something went wrong");
            }
           }
          

        }
        ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="user_name" placeholder="Username:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div>
        <div><p>Already Registered <a href="login.php">Login Here</a></p></div>
      </div>
    </div>
</body>
</html>