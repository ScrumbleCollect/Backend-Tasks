<?php 
        session_start();
        include "db_conn.php";

        if (isset($_POST['save'])) {

                $name = $_POST['name'];
                $color = $_POST['color'];
                $price = $_POST['price'];
                //prevent product changed to empty fields
                if (!$name){
                    $name = $_SESSION['productList'][0]['product_name'];
                }
                if (!floatval($price)){
                    $price = $_SESSION['productList'][0]['price'];
                }
                if (!$color){
                    $color = $_SESSION['productList'][0]['color'];
                }

                //send changes to database
                $id = $_SESSION['productList'][0]['product_id'];
                $sql = "UPDATE products SET product_name='$name', color='$color', price='$price' WHERE product_id=$id"; 
                if(mysqli_query($conn, $sql)){ 
                    echo "<script type='text/javascript'>alert('Changes Saved');</script>";
                    header('location: home.php');
                    exit();
                } else { 
                    echo "ERROR: Could not able to execute $sql. "  
                                            . mysqli_error($link); 
                }  
                
        }

    
        ?>

<!DOCTYPE html>
<html>
<head>
        <title>Update</title>
</head>
<body>
        <form method="post" action="editProduct.php" >
                <div class="input-group">
                        <label>Product_Name</label>
                        <input type="text" name="name" value="">
                </div>
                <div class="input-group">
                        <label>Colour</label>
                        <input type="text" name="color" value="">
                </div>
                <div class="input-group">
                        <label>Price</label>
                        <input type="float" name="price" value="">
                </div>
                <div class="input-group">
                        <button class="btn" type="submit" name="save" >Save</button>
                </div>
                <a href="home.php">Home</a>
        </form>
</body>
</html>