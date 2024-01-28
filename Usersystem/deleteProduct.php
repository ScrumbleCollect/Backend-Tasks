<?php 

include "db_conn.php"; 

if (isset($_GET['product_id'])) {
    
    $product_id = $_GET['product_id'];

    $sql = "DELETE FROM products WHERE product_id='$product_id'";

    $result = mysqli_query($conn, $sql);
    
     if ($result == TRUE) {
        echo "<script type='text/javascript'>alert('Product has been deleted');</script>";
        header('location: home.php');
        exit();

    }else{

        echo "Error:" . $sql . "<br>" . $conn->error;

    }

} 

?>