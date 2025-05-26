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
$query = "SELECT Username from $tabledb WHERE UserID = $ID";
$result = mysqli_query($con,$query);
if($result){
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $USERNAME = $row['Username'];
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
    <link href="Home.css" rel="stylesheet">
    <link rel="shortcut icon" type="icon" href="../Image/martxicon.png">
    <title>MartX - Home</title>
</head>
<body>
    <div class="top">
        <div>
            <a href="#"><img src="../Image/pic.png" alt="MartX" height="70px" width="140px"></a>
        </div>
        <div>
            <form class="search-form" action="Search.php">
                <input type="text" id="search" name="search" placeholder="Search By Name, Category, Brand...">
                <button type="submit"><img src="../Image/search.png" height="25px" width="25px"></button>
            </form>
        </div>
        <div class="login">
            <a href="Profile.php"><?php echo $USERNAME?></a>
            <span class="cart-count"><?php echo $cartItemsCount ?></span>
            <a href="../Cart/Cart.php" class="cart-link"><img src="../Image/cart.png" width="24px" height="20px"></a>
            <a href="../Main/destroy_session.php">Log Out</a>
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
    <h1>Company's Profile</h1>
    <div class="company_profile_container">
        <div class="company_profile">
            <img src="../Image/pic.png" height="300px" width="400px" alt="MartX">
            <div class="company_detail">
                <p>Company : Martx</p>
                <p>Company Contact : 095414911</p>
                <p>Company Email : martx.ecommerce@gmail.com</p>
            </div>
        </div>
    </div>
    <h1>What You Can Find In Our Site</h1>
    <div class="slideshow-container">
        <div class="slide">
            <a href="HomeAppliances.php"><img src="../Image/homeappliances.png" alt="Home Appliances"></a>
        </div>
        <div class="slide">
            <a href="Clothing.php"><img src="../Image/clothing.png" alt="Clothing"></a>
        </div>
        <div class="slide">
            <a href="Electronics.php"><img src="../Image/electronics.png" alt="Electronics"></a>
        </div>
        <div class="slide">
            <a href="Furnitures.php"><img src="../Image/furnitures.png" alt="Furnitures"></a>
        </div>
        <div class="slide">
            <a href="Accessories.php"><img src="../Image/accessories.jpg" alt="Accessories"></a>
        </div>
        <div class="slide">
            <a href="Sports.php"><img src="../Image/sports.png" alt="Sports"></a>
        </div>
        <div class="slide">
            <a href="Kitchen.php"><img src="../Image/kitchen.png" alt="Kitchen"></a>
        </div>
        <div class="slide">
            <a href="Cosmetics.php"><img src="../Image/cosmetics.png" alt="Cosmetics"></a>
        </div>
        <div class="slide">
            <a href="Footwear.php"><img src="../Image/footwear.jpg" alt="Footwear"></a>
        </div>
    </div>
    <h1>New Products</h1>
    <div class="item-flex-container">
    <?php
    $host = "localhost";
    $user = "root";
    $passwd = "";
    $database = "martx";
    $tabledb = "items";
    $con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect to database");
    $query = "select * from $tabledb ORDER BY itemID DESC LIMIT 5";
    $result = mysqli_query($con,$query);
    if($result){
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<form action='../Order/buy.php' method='POST'>";
                echo "<button type='submit' class='item-container'>";
                echo "<input type='hidden' name='id' value='{$row['itemID']}'>";
                echo "<img class='item-image' src='../Items/{$row['itemCategory']}/{$row['itemPhoto']}' alt='{$row['itemName']}'>";
                echo "<div class='item-details'>";
                echo "<p class='item-name'>{$row['itemName']}</p>";
                echo "<p class='item-detail'><strong>Brand:</strong> {$row['itemBrand']}</p>";
                echo "<p class='item-detail'><strong>Price:</strong> \${$row['itemPrice']}</p>";
                echo "</div>";
                echo "</button>";
                echo "</form>";
            }
        }else{
            echo "<div class='no-data-found'>No item found!</div>";
        }
    }else {
        echo "<script>alert('Error occuring!');</script>";
    }
    mysqli_close($con);
    ?>
    </div>
    <footer>
        <p>&copy; 2024 MartX. All rights reserved</p>
    </footer>
    <script lang="javascript" type="text/javascript">
        let slideIndex = 0;
        const slides = document.querySelectorAll('.slide');

        function showSlides() {
            slides.forEach(slide => {
                slide.style.display = 'none';
            });

            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }

            slides[slideIndex - 1].style.display = 'block';
            setTimeout(showSlides, 3000);
        }
        showSlides();
    </script>
</body>
</html>