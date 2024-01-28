<?php 
session_start();
include "db_conn.php";

if (isset($_POST["Search"])) {
     //if product exists go to product page
     $name = $_POST["product_search"];
     $sql = "SELECT * FROM products WHERE product_name = '$name'";
     $result = mysqli_query($conn, $sql);
     $rowCount = mysqli_num_rows($result);
     $_SESSION['productList'] = $result;
     if ($rowCount>0) {
          //prepare product for editing or delete
          $productList = array(); 
          while ($row = mysqli_fetch_assoc($result)) {
               $productList[] = $row; 
          }
          $_SESSION['productList'] = $productList; 
          
          mysqli_free_result($result); 
          
          header('Location: product.php');
          exit();
     }
     else{
          
          echo "<script type='text/javascript'>alert('Product does not exist');</script>";
     }
}
     
if (isset($_POST["Create"])) {

     $productName = $_POST["productName"];
     $productColor = $_POST["productColor"];
     $productPrice = floatval($_POST["productPrice"]);
     if (empty($productName) OR empty($productColor) OR empty($productPrice)) {
          echo "<script type='text/javascript'>alert('All 3 fields are required for creating a product!!!');</script>";
         }
     else{
          //check if product exists
          
          $sql = "SELECT * FROM products WHERE product_name = '$productName'";
          $result = mysqli_query($conn, $sql);
          $rowCount = mysqli_num_rows($result);
          if ($rowCount>0) {
               echo "<script type='text/javascript'>alert('Product already exists');</script>";
          }
          else{

          // prepare id for product from current max id
          $sql = "SELECT * FROM products ORDER BY product_id DESC LIMIT 1";
               
          $result = mysqli_query($conn, $sql);
          $rowcount=mysqli_num_rows($result);
          if ($rowcount == 0){
               $productId = 1;
          }
          else{
               $productId = (int)mysqli_fetch_array($result)[0] + 1;
          }
          //insert product into database
          $sql = "INSERT INTO products (product_id, product_name, color, price) VALUES ( ?, ?, ?, ? )";
               $stmt = mysqli_stmt_init($conn);
               $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
               if ($prepareStmt) {
               
                    mysqli_stmt_bind_param($stmt, "issd", $productId, $productName, $productColor, $productPrice);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>Product is successfully created</div>";
             
               }else{
                    die("Something went wrong");
               }
          }
     }
}
     
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>HOME</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
     <h1>Hello, <?php echo $_SESSION['user_name']; ?></h1>
     <form action="home.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="product_search" placeholder="Enter product name: ">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="search" name="Search">
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="productName" placeholder="Enter new product name: ">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="productColor" placeholder="Enter product color: ">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="productPrice" placeholder="Enter product price($): ">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="create" name="Create">
            </div>

        </form>
     <a href="logout.php">Logout</a>
</body>
</html>

