<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="HStyle.css" rel="stylesheet">
    <link rel="shortcut icon" type="icon" href="../Image/martxicon.png">
    <title>MartX - Search(<?php echo $_GET['search']; ?>)</title>
</head>
<body>
    <div class="top">
        <div>
            <a href="Home.php"><img src="../Image/pic.png" alt="MartX" height="70px" width="140px"></a>
        </div>
        <div>
            <form class="search-form">
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
    <h3>Things related with - <?php echo $_GET['search']; ?></h3>
    <div class="item-flex-container">
    <?php
    $host = "localhost";
    $user = "root";
    $passwd = "";
    $database = "martx";
    $tabledb = "items";
    $key = $_GET['search'];
    if($key == ""){
        echo "<div class='no-data-found'>No item found!</div>";
        exit;
    }
    $con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect to database");
    $sql = "SELECT * FROM $tabledb WHERE itemName LIKE '%$key%' OR itemCategory LIKE '%$key%' OR itemBrand LIKE '%$key%'";
    $result = mysqli_query($con,$sql);
    if($result){
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<form action='buy.php' method='POST'>";
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
</body>
</html>