<?php
session_start();
if (!isset($_SESSION['ID'])) {
    header("Location: ../Main/Login.php");
    exit;
}
$host = "localhost";
$user = "root";
$passwd = "";
$database = "martx";
$tableuser = "user";
$tableitem = "items";
$tablecartitems = "cartitems";
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
$sql = "SELECT * from $tableuser WHERE UserID = '".$ID."' AND blockStatus = '1'";
$block = mysqli_query($con, $sql);
if($block){
    $count = mysqli_num_rows($block);
    if($count > 0){
        echo "<script>alert('You are blocked!'); window.location.href='../Main/Home.php';</script>";
    }
}
$address = $_POST['address'];
$userQUERY = "SELECT * from $tableuser WHERE UserID = '".$ID."'";
$userRESULT = mysqli_query($con,$userQUERY);
if($userRESULT){
    $userROW = mysqli_fetch_array($userRESULT,MYSQLI_ASSOC);
    $USERNAME = $userROW['Username'];
    $PHONE = $userROW['Phone'];
    $EMAIL = $userROW['Email'];
    $ADDRESS = $userROW['Address'];
}else{
    echo "<script>alert('Error: Order Failed!'); window.location.href='Cart.php'</script>";
}
$cartitemQUERY = "SELECT * FROM $tablecartitems WHERE cartID = '$ID'";
$cartitemRESULT = mysqli_query($con, $cartitemQUERY);
while($cartROW = mysqli_fetch_array($cartitemRESULT, MYSQLI_ASSOC)){
    $itemID = $cartROW['itemID'];
    $quantity = $cartROW['quantity'];
    $condition = "SELECT * FROM $tableitem WHERE itemID = '$itemID' AND itemQuantity < '$quantity'";
    $outofstock = mysqli_query($con, $condition);
    $row_count = mysqli_num_rows($outofstock);
    if($row_count > 0){
        $itemROW = mysqli_fetch_array($outofstock, MYSQLI_ASSOC);
        $OUTitem = $itemROW['itemName'];
        $remove = "DELETE FROM $tablecartitems WHERE cartID = '$ID' AND itemID = '$itemID'";
        $result = mysqli_query($con, $remove);
        if($result){
            echo "<script>alert('$OUTitem quantity exceeds the available quantity!'); window.location.href='Cart.php'</script>";
            exit;
        }
    }
}
$orderquery = "INSERT INTO $tableorder (UserID, orderDate, deliverAddress) VALUES (?, ?, ?)";
$orderstmt = mysqli_prepare($con, $orderquery);
$current_date = date('Y-m-d');
mysqli_stmt_bind_param($orderstmt, "iss", $ID, $current_date, $address);
if (mysqli_stmt_execute($orderstmt)) {
    $orderID = $con->insert_id;
    $totalitem = "SELECT * FROM $tablecartitems WHERE cartID = '".$ID."'";
    $output = mysqli_query($con, $totalitem);
    if($output){
        while($ROW = mysqli_fetch_array($output, MYSQLI_ASSOC)){
            $ITEMID = $ROW['itemID'];
            $ITEMQUANTITY =  $ROW['quantity'];
            $detailquery = "INSERT INTO $tabledetail (orderID, itemID, quantity) VALUES (?, ?, ?)";
            $detailstmt = mysqli_prepare($con, $detailquery);
            mysqli_stmt_bind_param($detailstmt, "iii", $orderID, $ITEMID, $ITEMQUANTITY);
            if (mysqli_stmt_execute($detailstmt)) {
                $update = "UPDATE items SET itemQuantity = itemQuantity - ? WHERE itemID = ?";
                $updtstmt = mysqli_prepare($con, $update);
                mysqli_stmt_bind_param($updtstmt, "ii", $ITEMQUANTITY, $ITEMID);
                if(mysqli_stmt_execute($updtstmt)){
                    $deletecart = "DELETE FROM $tablecartitems WHERE cartID = '".$ID."'";
                    mysqli_query($con, $deletecart);
                }
                mysqli_stmt_close($updtstmt);
            }else{
                echo "<script>alert('Error: Order Failed!'); window.location.href='Cart.php';</script>";
            }
            mysqli_stmt_close($detailstmt);
        }
    }
} else {
    echo "<script>alert('Error: Order Failed!'); window.location.href='Cart.php';</script>";
}
mysqli_stmt_close($orderstmt);
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="Receipt.css" rel="stylesheet">
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
            <?php
                $total_price = 0;
                $con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect to the database");
                $SELECTorder = "SELECT * FROM $tableorder WHERE orderID = '".$orderID."'";
                $SELECT_RUN = mysqli_query($con, $SELECTorder);
                if($SELECT_RUN){
                    $SELECT_ROW = mysqli_fetch_array($SELECT_RUN, MYSQLI_ASSOC);
                    $DATE = $SELECT_ROW['orderDate'];
                    $DELIVERY = $SELECT_ROW['deliverAddress'];
                    $retrieve = "SELECT * FROM $tabledetail WHERE orderID = '".$orderID."'";
                    $run = mysqli_query($con, $retrieve);
                    if($run){
                        while($totalorder = mysqli_fetch_array($run, MYSQLI_ASSOC)){
                            $idofitem = $totalorder['itemID'];
                            $quantityofitem = $totalorder['quantity'];
                            $item = "SELECT * FROM $tableitem where itemID = '".$idofitem."'";
                            $runitem = mysqli_query($con, $item);
                            if($runitem){
                                $itemrow = mysqli_fetch_array($runitem, MYSQLI_ASSOC);
                                $ITEMNAME = $itemrow['itemName'];
                                $UNIT = $itemrow['itemPrice'];
                                $TOTALPRICE = $UNIT * $quantityofitem;
                                echo "<tr>";
                                echo "<td>$orderID</td>";
                                echo "<td>$ITEMNAME</td>";
                                echo "<td>$quantityofitem</td>";
                                echo "<td>\$$UNIT</td>";
                                echo "<td>\$$TOTALPRICE</td>";
                                echo "</tr>";
                            }
                            $total_price += $TOTALPRICE;
                        }
                        echo "<tr>";
                        echo "<td colspan='4' style='text-align: right;'><strong>Total Price:</strong></td>";
                        echo "<td><strong>\$$total_price</strong></td>";
                        echo "</tr>";
                    }
                }
                mysqli_close($con);
            ?>
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