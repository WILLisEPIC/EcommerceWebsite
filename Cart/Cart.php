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
$tabledb = "user";
$ID = $_SESSION['ID'];
$con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect to the database");
$query = "SELECT * from $tabledb WHERE UserID = $ID";
$result = mysqli_query($con,$query);
if($result){
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $USERNAME = $row['Username'];
    $ADDRESS = $row['Address'];
}else{
    echo "Error";
}
$cartquery = "SELECT * FROM cartitems where cartID = '$ID'";
$carttotal = mysqli_query($con, $cartquery);
if($carttotal){
    $cartItemsCount = mysqli_num_rows($carttotal);
}else{
    echo "Error";
}
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="cart.css" rel="stylesheet">
    <link rel="shortcut icon" type="icon" href="../Image/martxicon.png">
    <title>MartX - Cart</title>
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
            <a href="#" class="cart-link"><img src="../Image/cart.png" width="24px" height="20px"></a>
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
    <div class="cart">
        <div class="item-container">
            <table border="0">
                <th>Item<th>Name<th>Quantity<th>Unit Price<th>Totoal Price<th>
                <?php
                $host = "localhost";
                $user = "root";
                $passwd = "";
                $database = "martx";
                $cart = "cartitems";
                $total_amount = 0;
                $con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect to the database");
                $sql = "SELECT * from $tabledb WHERE UserID = '".$ID."' AND blockStatus = '1'";
                $block = mysqli_query($con, $sql);
                if($block){
                    $count = mysqli_num_rows($block);
                    if($count > 0){
                        echo "<script>alert('You are blocked!'); window.location.href='../Main/Home.php';</script>";
                    }
                }
                $select = "SELECT * FROM $cart WHERE cartID = '".$ID."'";
                $output = mysqli_query($con, $select);
                if($output){
                    $row_count = mysqli_num_rows($output);
                    if ($row_count > 0) {
                        while ($data = mysqli_fetch_array($output, MYSQLI_ASSOC)) {
                            $ITEMID = $data['itemID'];
                            $QUANTITY = $data['quantity'];
                            $itemquary = "SELECT * FROM items WHERE itemID = '".$ITEMID."'";
                            $selectitem = mysqli_query($con, $itemquary);
                            if($selectitem){
                                $itemdata = mysqli_fetch_array($selectitem, MYSQLI_ASSOC);
                                $NAME = $itemdata['itemName'];
                                $CATEGORY = $itemdata['itemCategory'];
                                $PRICE = $itemdata['itemPrice'];
                                $AVAILABLEQUANTITY = $itemdata['itemQuantity'];
                                $PHOTO = $itemdata['itemPhoto'];
                                $TOTAL = $QUANTITY * $PRICE;
                                echo "<tr>";
                                echo "<td><img src='../Items/$CATEGORY/$PHOTO' alt='$NAME' height='80px' width='90px'></td>";
                                echo "<td>$NAME</td>";
                                echo "<td>$QUANTITY</td>";
                                echo "<td>\$$PRICE</td>";
                                echo "<td>\$$TOTAL</td>";
                                echo "<td>";
                                echo "<form method='POST'>";
                                echo "<input type='hidden' name='itemid' value='".$ITEMID."'>";
                                echo "<button type='submit' name='remove'><img src='../Image/cancel.png' alt='Cancel' width='20px' height='20px'></button>";
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            $total_amount += $TOTAL;
                        }
                    }
                }
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove'])) {
                    $deleteID = $_POST['itemid'];
                    $con = mysqli_connect($host, $user, $passwd, $database) or die("Could not connect to the database");
                    $delete = "DELETE FROM $cart WHERE itemID = '".$deleteID."'";
                    mysqli_query($con, $delete);
                    mysqli_close($con);
                    echo "<script>window.location.href='Cart.php'</script>";
                }
                ?>
            </table>
        </div>
        <div class="method-container">
        <form method="POST" id="orderForm">
            <div class="policy">
                <strong>Delivery</strong>
                <div class="delivery-address">
                    <img src="../Image/location.png" alt="location" width="30px" height="25px">
                    <textarea name="address" rows="4" cols="27" required><?php echo $ADDRESS ?></textarea>
                </div>
                <strong>Payment Method</strong>
                <div class="payment-method">
                    <img src="../Image/payment.png" alt="location" width="30px" height="25px">
                    <p>Cash On Delivery Only</p>
                </div>
                <strong>Company</strong>
                <div class="company-logo">
                    <img src="../Image/pic.png" alt="MartX">
                </div>
            </div>
            <div class="total_amount">
                <p>Total Amount: <strong>$<?php echo $total_amount; ?></strong></p>
            </div>
            <div class="button_container">
                <button type="button" id="buy" <?php  echo $row_count <= 0 ? 'disabled' : ''; ?>>Buy</button>
            </div>
        </div>
        <div class="modal" id="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <p>Confirm</p>
                    <span class="close" id="close">&times;</span>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to buy?</p>
                    <div class="modal-button">
                        <button type="submit" name="yes" id="yes">Yes</button>
                        <button type="button" id="no">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    <footer>
        <p>&copy; 2024 MartX. All rights reserved</p>
    </footer>
    <script type="text/javascript">
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById('modal').style.display = 'block';
            }
        });

        document.getElementById("buy").addEventListener("click", function(event) {
            document.getElementById('modal').style.display = 'block';
        });

        document.getElementById("yes").addEventListener("click", function(event) {
            setFormAction("Receipt.php");
        });

        document.getElementById("no").addEventListener("click", function(event) {
            document.getElementById('modal').style.display = 'none';
        });

        document.getElementById("close").addEventListener("click", function(event) {
            document.getElementById('modal').style.display = 'none';
        });

        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                document.getElementById('modal').style.display = 'none';
            }
        });

        function setFormAction(action) {
            const addressField = document.querySelector('textarea[name="address"]');
            if (!addressField.value.trim()) {
                document.getElementById('modal').style.display = 'none';
                return;
            }
            document.getElementById('orderForm').action = action;
            document.getElementById('orderForm').submit();
        }
    </script>
</body>
</html>