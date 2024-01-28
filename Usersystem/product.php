<?php 
session_start();
include "db_conn.php";

?>
<html>
<head>
	<title>HOME</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
     <h1>Hello, <?php echo $_SESSION['user_name']; ?></h1>
     <table>
        <thead>
                <tr>
                        <th>Product Name</th>
                        <th>Color</th>
                        <th>Product Price($)</th>
                </tr>
        </thead>
        
        <?php foreach ($_SESSION['productList'] as $row) { ?>
                <tr>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['color']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td>
                                <a href="editProduct.php?edit=<?php echo $row['product_id']; ?>" class="edit_btn">Edit</a>
                        </td>
                        <td>
                       
                        <a href="deleteProduct.php?product_id=<?php echo $row['product_id']; ?>" class="btn btn-danger">Delete</a>
                       
                        </td>
                </tr>
        <?php } ?>
</table>
     <a href="home.php">Home</a>
     <a href="logout.php">Logout</a>
</body>
</html>

