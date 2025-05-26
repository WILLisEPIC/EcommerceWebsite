<?php
session_start();
if (!isset($_SESSION['ID'])) {
    header("Location: ../Main/Login.php");
    exit;
}
if(($_SERVER["REQUEST_METHOD"]=="POST") && isset($_POST['yes'])){
    $host = "localhost";
    $user = "root";
    $passwd = "";
    $database = "martx";
    $tabledb = "user";
    $tabledb2 = "items";
    $tableorder = "orders";
    $tabledetail = "orderdetails";
    $ID = $_SESSION['ID'];
    $con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect to the database");
    $cartquery = "SELECT * FROM cartitems where cartID = '$ID'";
    $carttotal = mysqli_query($con, $cartquery);
    if($carttotal){
        $cartItemsCount = mysqli_num_rows($carttotal);
    }else{
        echo "Error";
    }
    $sql = "SELECT * from $tabledb WHERE UserID = '".$ID."' AND blockStatus = '1'";
    $block = mysqli_query($con, $sql);
        if($block){
            $count = mysqli_num_rows($block);
            if($count > 0){
                echo "<script>alert('You are blocked!'); window.location.href='../Main/Home.php';</script>";
            }
        }
    $itemid = $_POST['id'];
    $address = $_POST['address'];
    $quantity = $_POST['quantity'];
    $query = "SELECT * from $tabledb WHERE UserID = '".$ID."'";
    $result = mysqli_query($con,$query);
        if($result){
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $USERNAME = $row['Username'];
            $PHONE = $row['Phone'];
            $EMAIL = $row['Email'];
            $ADDRESS = $row['Address'];
        }else{
            echo "<script>alert('Error: Order Failed!'); window.location.href='../User/Home.php'</script>";
        }
    $query2 = "SELECT * from $tabledb2 WHERE itemID = '".$itemid."'";
    $result2 = mysqli_query($con,$query2);
        if($result2){
            $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
            $NAME = $row2['itemName'];
            $CATEGORY = $row2['itemCategory'];
            $BRAND = $row2['itemBrand'];
            $PRICE = $row2['itemPrice'];
            $QUANTITY = $row2['itemQuantity'];
            $PHOTO = $row2['itemPhoto'];
        }else{
            echo "<script>alert('Error: Order Failed!'); window.location.href='../User/$CATEGORY.php';</script>";
        }
    $condition = "SELECT * from $tabledb2 WHERE itemID = '".$itemid."' AND itemQuantity <= 0";
    $result3 = mysqli_query($con,$condition);
        if($result3){
            $row_count = mysqli_num_rows($result3);
            if ($row_count > 0) {
                echo "<script>alert('Error: Order Failed!'); window.location.href='../User/$CATEGORY.php';</script>";
            }else{
                $orderquery = "INSERT INTO $tableorder (UserID, orderDate, deliverAddress) VALUES (?, ?, ?)";
                $orderstmt = mysqli_prepare($con, $orderquery);
                $current_date = date('Y-m-d');
                mysqli_stmt_bind_param($orderstmt, "iss", $ID, $current_date, $address);
                if (mysqli_stmt_execute($orderstmt)) {
                    $orderID = $con->insert_id;
                    $detailquery = "INSERT INTO $tabledetail (orderID, itemID, quantity) VALUES (?, ?, ?)";
                    $detailstmt = mysqli_prepare($con, $detailquery);
                    mysqli_stmt_bind_param($detailstmt, "iii", $orderID, $itemid, $quantity);
                    if (mysqli_stmt_execute($detailstmt)) {
                        $total = $QUANTITY - $quantity;
                        $update = "UPDATE items SET itemQuantity = ? WHERE itemID = ?";
                        $updtstmt = mysqli_prepare($con, $update);
                        mysqli_stmt_bind_param($updtstmt, "ii", $total, $itemid);
                        mysqli_stmt_execute($updtstmt);
                        mysqli_stmt_close($updtstmt);
                    }else{
                        echo "<script>alert('Error: Order Failed!'); window.location.href='../User/$CATEGORY.php';</script>";
                    }
                    mysqli_stmt_close($detailstmt);
                } else {
                    echo "<script>alert('Error: Order Failed!'); window.location.href='../User/$CATEGORY.php';</script>";
                }
                mysqli_stmt_close($orderstmt);
            }
        }
    mysqli_close($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="receipt.css" rel="stylesheet">
    <link rel="shortcut icon" type="icon" href="../Image/martxicon.png">
    <title>MartX - Order Receipt</title>
</head>
<body>
    <div class="top">
        <div>
            <a href="../User/Home.php"><img src="../Image/pic.png" alt="MartX" height="70px" width="140px"></a>
        </div>
        <div>
            <form class="search-form" action="../User/Search.php">
                <input type="text" id="search" name="search" placeholder="Search By Name, Category, Brand...">
                <button type="submit"><img src="../Image/search.png" height="25px" width="25px"></button>
            </form>
        </div>
        <div class="login">
            <a href="../User/Profile.php"><?php echo $USERNAME?></a>
            <span class="cart-count"><?php echo $cartItemsCount ?></span>
            <a href="../Cart/Cart.php" class="cart-link"><img src="../Image/cart.png" width="24px" height="20px"></a>
            <a href="../Main/destroy_session.php">Log Out</a>
        </div>
    </div>
    <ul class="nav nav-underline">
        <li class="nav-item">
            <a class="nav-link" href="../User/HomeAppliances.php">Home Appliances</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../User/Clothing.php">Clothing</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../User/Electronics.php">Electronics</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../User/Furnitures.php">Furnitures</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../User/Accessories.php">Accessories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../User/Sports.php">Sports</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../User/Kitchen.php">Kitchen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../User/Cosmetics.php">Cosmetics</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../User/Footwear.php">Footwear</a>
        </li>
    </ul>
    <hr>
    <center>Your Receipt</center>
    <div class="receipt-container">
        <div class="company">
            <div class="company-profile">
                <div class="company-detail">
                <p style="text-decoration: underline;">Company's Informatiom</p>
                    <p>Company : <strong>MartX</strong></p>
                    <p>Email   : <strong>martx.ecommerce@gmail.com</strong></p>
                    <p>Phone : <strong>095414911</strong></p>
                </div>
            </div>
            <div class="company-logo">
                <img src = "../Image/pic.png" alt="Martx" height="60px" width="100px">
            </div>
        </div>
        <hr>
        <div class="user-container">
            <div class="user-info">
                <p style="text-decoration: underline;">Customer's Information</p>
                <p>Name    : <strong><?php echo $USERNAME ?></strong></p>
                <p>Phone   : <strong><?php echo $PHONE ?></strong></p>
                <p>Email   : <strong><?php echo $EMAIL ?></strong></p>
                <p>Address : <strong><?php echo $ADDRESS ?></strong></p>
            </div>
            <div class="deliver-info">
                <div class="deliver-add">
                    <p style="text-decoration: underline;">Deliverable Address</p>
                    <textarea rows="3" cols="40" disabled><?php echo $address ?></textarea>
                </div>
                <div class="payment-method">
                    <p style="text-decoration: underline;">Payment Method</p>
                    <img src="../Image/payment.png" alt="location" width="30px" height="25px">Cash On Delivery Only
                </div>
            </div>
        </div>
        <hr>
        <div class="item-container">
            <table>
                <th>Order Id<th>Item Name<th>Quantity<th>Unit Price<th>Total Price
                <tr>
                    <td><?php echo $orderID ?></td>
                    <td><?php echo $NAME ?></td>
                    <td><?php echo $quantity ?></td>
                    <td><?php echo $PRICE ?></td>
                    <td><?php echo $quantity * $PRICE ?></td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p>Thanks For Shopping With Us</p>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 MartX. All rights reserved</p>
    </footer>
</body>
</html>