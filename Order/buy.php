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
$tabledb2 = "items";
$ID = $_SESSION['ID'];
$itemid = $_POST['id'];
$con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect to the database");
$query = "SELECT Username, Address from $tabledb WHERE UserID = '".$ID."'";
$result = mysqli_query($con,$query);
if($result){
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $USERNAME = $row['Username'];
    $ADDRESS = $row['Address'];
}else{
    echo "Error";
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
    <link href="buy.css" rel="stylesheet">
    <link rel="shortcut icon" type="icon" href="../Image/martxicon.png">
    <title>MartX - Item</title>
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
    <div class="item-flex-container">
        <form class="item-container" method="POST" id="orderForm">
            <input type="hidden" name="id" value="<?php echo $itemid ?>">
            <img class="item-image" src="../Items/<?php echo $CATEGORY ?>/<?php echo $PHOTO ?>" alt='<?php echo $NAME ?>'>
            <div class="item-details">
                <p class="item-name"><?php echo $NAME ?></p>
                <p class="item-detail"><strong>Category:</strong> <?php echo $CATEGORY ?></p>
                <p class="item-detail"><strong>Made:</strong> <?php echo $BRAND ?></p>
                <p class="item-price">$ <?php echo $PRICE ?></p>
                <div class="quantity-container">
                    <p>Quantity </p>
                    <button type="button" id="minus" disabled>-</button>
                    <input type="<?php echo ($QUANTITY > 0) ? 'number' : 'text'; ?>" name="quantity" id="quantity" min="1" max="<?php echo $QUANTITY; ?>" value="<?php echo ($QUANTITY > 0) ? 1 : 'Out Of Stock'; ?>" <?php echo ($QUANTITY <= 0) ? 'readonly' : 'readonly'; ?>>
                    <button type="button" id="plus" <?php echo ($QUANTITY <= 0) ? 'disabled' : ''; ?>>+</button>
                </div>
                <div class="button-container">
                    <div class="buy"><button type="button" name="buy" id="buy" <?php echo ($QUANTITY <= 0) ? 'disabled' : ''; ?>>Buy</button></div>
                    <div class="add"><button type="submit" name="add" id="addToCartBtn" <?php echo ($QUANTITY <= 0) ? 'disabled' : ''; ?>>Add To Cart</button></div>
                </div>
            </div>
            <div class="method-container">
                <strong>Delivery</strong>
                <div class="delivery-address">
                    <img src="../Image/location.png" alt="location" width="30px" height="25px">
                    <textarea name="address" rows="4" cols="27" <?php echo ($QUANTITY <= 0) ? 'disabled' : ''; ?> required><?php echo $ADDRESS ?></textarea>
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
            <div class="modal" id="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <p>Confirm</p>
                        <span class="close" id="close">&times;</span>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to buy <?php echo $NAME ?>?</p>
                        <div class="modal-button">
                            <button type="submit" name="yes" id="yes">Yes</button>
                            <button type="button" id="no">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="reminder">
            <p style="text-decoration: underline; color: red;">Once you buy it you can't cancel it.</p>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 MartX. All rights reserved</p>
    </footer>
    <script>
        const plusButton = document.getElementById('plus')
        const minusButton = document.getElementById('minus')
        const quantityInput = document.getElementById('quantity')

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById('modal').style.display = 'block';
            }
        });

        document.getElementById("buy").addEventListener("click", function(event) {
            document.getElementById('modal').style.display = 'block';
        });

        document.getElementById("no").addEventListener("click", function(event) {
            document.getElementById('modal').style.display = 'none';
        });

        document.getElementById("yes").addEventListener("click", function(event) {
            setFormAction("receipt.php");
        });

        document.getElementById("close").addEventListener("click", function(event) {
            document.getElementById('modal').style.display = 'none';
        });

        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                document.getElementById('modal').style.display = 'none';
            }
        });

        if (plusButton && minusButton && quantityInput) {
            plusButton.addEventListener('click', () => {
                if (parseInt(quantityInput.value) < <?php echo $QUANTITY ?>) {
                    quantityInput.value = parseInt(quantityInput.value) + 1;
                    minusButton.disabled = false;
                }

                if (parseInt(quantityInput.value) === <?php echo $QUANTITY ?>) {
                    plusButton.disabled = true;
                }
            });

            minusButton.addEventListener('click', () => {
                if (parseInt(quantityInput.value) > 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                    plusButton.disabled = false;
                }

                if (parseInt(quantityInput.value) === 1) {
                    minusButton.disabled = true;
                }
            });
        }

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
    <?php
    if(($_SERVER["REQUEST_METHOD"]=="POST") && isset($_POST['add'])){
    $host = "localhost";
    $user = "root";
    $passwd = "";
    $database = "martx";
    $cart = "cartitems";
    $con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect to the database");
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];
    $sql = "SELECT * from $tabledb WHERE UserID = '".$ID."' AND blockStatus = '1'";
    $block = mysqli_query($con, $sql);
    if($block){
        $count = mysqli_num_rows($block);
        if($count > 0){
            echo "<script>alert('You are blocked!'); window.location.href='../Main/destroy_session.php';</script>";
        }
    }
    $select = "SELECT * FROM $cart WHERE cartID = '".$ID."' AND itemID = '".$id."'";
    $selectquery = mysqli_query($con, $select);
    $row_count = mysqli_num_rows($selectquery);
    if ($row_count > 0) {
        $array = mysqli_fetch_array($selectquery, MYSQLI_ASSOC);
        $NEWQUANTITY = $quantity + $array['quantity'];
        $validateSQL = "SELECT itemQuantity FROM items WHERE itemID = '".$id."'";
        $validate = mysqli_query($con, $validateSQL);
        $availablequantity = mysqli_fetch_array($validate);
        $itemQuantity = $availablequantity['itemQuantity'];
        if ($NEWQUANTITY > $itemQuantity) {
            echo "<script>error('$itemQuantity');</script>";
        }else{
            $updatequery = "UPDATE $cart SET quantity = '".$NEWQUANTITY."' WHERE itemID = '".$id."'";
            $update = mysqli_query($con, $updatequery);
            if($update){
                echo "<script>window.location.href='../Cart/Cart.php';</script>";
            }else{
                echo "<script>alert('Error!');</script>";
            }
        }
    }else{
        $insertcart = "INSERT INTO $cart (cartID, itemID, quantity) VALUES ('".$ID."','".$id."','".$quantity."')";
        $insert = mysqli_query($con, $insertcart);
        if($insert){
            echo "<script>window.location.href='../Cart/Cart.php';</script>";
        }else{
            echo "<script>alert('Error!');</script>";
        }
    }
    mysqli_close($con);
    }
    ?>
</body>
</html>