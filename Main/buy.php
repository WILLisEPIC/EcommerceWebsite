<?php
$host = "localhost";
$user = "root";
$passwd = "";
$database = "martx";
$tabledb = "items";
$ID = $_POST['id'];
$con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect to the database");
$query = "SELECT * from $tabledb WHERE itemID = '$ID'";
$result = mysqli_query($con, $query);
if($result){
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $NAME = $row['itemName'];
    $CATEGORY = $row['itemCategory'];
    $BRAND = $row['itemBrand'];
    $PRICE = $row['itemPrice'];
    $QUANTITY = $row['itemQuantity'];
    $PHOTO = $row['itemPhoto'];
}else{
    echo "Error";
}
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
            <a href="Home.php"><img src="../Image/pic.png" alt="MartX" height="70px" width="140px"></a>
        </div>
        <div>
            <form class="search-form" action="Search.php">
                <input type="text" id="search" name="search" placeholder="Search By Name, Category, Brand...">
                <button type="submit"><img src="../Image/search.png" height="25px" width="25px"></button>
            </form>
        </div>
        <div class="login">
            <a href="SignUp.php">Sign Up</a>
            <a href="Login.php">Log In</a>
        </div>
    </div>
    <ul class="nav nav-underline">
    <li class="nav-item">
            <a class="nav-link" href="HomeAppliances.php">Home Appliances</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Clothing.php">Clothing</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Electronics.php">Electronics</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Furnitures.php">Furnitures</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Accessories.php">Accessories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Sports.php">Sports</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Kitchen.php">Kitchen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Cosmetics.php">Cosmetics</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Footwear.php">Footwear</a>
        </li>
    </ul>
    <hr>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="buyToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
            <img src="../Image/pic.png" class="rounded me-2" alt="MartX" width="70px" height="40px">
            <strong class="me-auto"></strong>
            <small class="text-body-secondary"></small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
            You must login to buy items!
            </div>
        </div>

        <div id="addToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
            <img src="../Image/pic.png" class="rounded me-2" alt="MartX" width="70px" height="40px">
            <strong class="me-auto"></strong>
            <small class="text-body-secondary"></small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
            You must login to add items into cart!
            </div>
        </div>
    </div>
    <div class="item-flex-container">
        <form class="item-container">
            <input type="hidden" name="id" value="<?php echo $ID ?>">
            <img class="item-image" src="../Items/<?php echo $CATEGORY ?>/<?php echo $PHOTO ?>" alt='<?php echo $NAME ?>'>
            <div class="item-details">
                <p class="item-name"><?php echo $NAME ?></p>
                <p class="item-detail"><strong>Category:</strong> <?php echo $CATEGORY ?></p>
                <p class="item-detail"><strong>Brand:</strong> <?php echo $BRAND ?></p>
                <p class="item-price">$ <?php echo $PRICE ?></p>
                <div class="quantity-container">
                    <p>Quantity </p>
                    <button type="button" id="minus" disabled>-</button>
                    <input type="<?php echo ($QUANTITY > 0) ? 'number' : 'text'; ?>" name="quantity" id="quantity" min="1" max="<?php echo $QUANTITY; ?>" value="<?php echo ($QUANTITY > 0) ? 1 : 'Out Of Stock'; ?>" <?php echo ($QUANTITY <= 0) ? 'readonly' : 'readonly'; ?>>
                    <button type="button" id="plus" <?php echo ($QUANTITY <= 0) ? 'disabled' : ''; ?>>+</button>
                </div>
                <div class="button-container">
                <div class="buy"><button type="button" name="buy" id="buy" <?php echo ($QUANTITY <= 0) ? 'disabled' : ''; ?>>Buy</button></div>
                    <div class="add"><button type="button" name="add" id="add" <?php echo ($QUANTITY <= 0) ? 'disabled' : ''; ?>>Add To Cart</button></div>
                </div>
            </div>
            <div class="method-container">
                <strong>Delivery</strong>
                <div class="delivery-address">
                    <img src="../Image/location.png" alt="location" width="30px" height="25px">
                    <textarea name="address" rows="4" cols="27" <?php echo ($QUANTITY <= 0) ? 'disabled' : ''; ?>>Deliverable Address</textarea>
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
        </form>
        <div class="reminder">
            <p style="text-decoration: underline; color: red;">Once you buy it you can't cancel it.</p>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 MartX. All rights reserved</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const buyButton = document.getElementById('buy')
        const addButton = document.getElementById('add')
        const buytoast = document.getElementById('buyToast')
        const addtoast = document.getElementById('addToast')
        const plusButton = document.getElementById('plus')
        const minusButton = document.getElementById('minus')
        const quantityInput = document.getElementById('quantity')

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });

        if (buyButton) {
            const buytoastBootstrap = new bootstrap.Toast(buytoast)
            buyButton.addEventListener('click', () => {
                buytoastBootstrap.show()
            })
        }

        if (addButton) {
            const addtoastBootstrap = new bootstrap.Toast(addtoast)
            addButton.addEventListener('click', () => {
                addtoastBootstrap.show()
            })
        }

        if (plusButton && minusButton && quantityInput) {
            plusButton.addEventListener('click', () => {
                if(parseInt(quantityInput.value) < <?php echo $QUANTITY ?>){
                    quantityInput.value = parseInt(quantityInput.value) + 1
                    minusButton.disabled = false
                }

                if(parseInt(quantityInput.value) === <?php echo $QUANTITY ?>){
                    plusButton.disabled = true
                }
            })

            minusButton.addEventListener('click', () => {
                if (parseInt(quantityInput.value) > 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1
                    plusButton.disabled = false
                }

                if (parseInt(quantityInput.value) === 1) {
                    minusButton.disabled = true
                }
            })
        }
    </script>
</body>
</html>