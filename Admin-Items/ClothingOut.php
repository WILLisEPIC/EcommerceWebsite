<?php
session_start();
if (!isset($_SESSION['Admin'])) {
    header("Location: ../Main/Login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="AdminView.css" rel="stylesheet">
    <link rel="shortcut icon" type="icon" href="../Image/martxicon.png">
    <title>MartX - Admin(Out of Stock Clothing)</title>
</head>
<body>
    <div class="top">
        <img src="../Image/pic.png" alt="MartX" height="70px" width="140px">
        <div>
            <form class="search-form" action="Search.php">
                <input type="text" id="search" name="search" placeholder="Search By ID, Name, Category, Brand...">
                <button type="submit"><img src="../Image/search.png" height="25px" width="25px"></button>
            </form>
        </div>
        <div class="login">
            <a href = "../Main/destroy_session.php">Log Out</a>
        </div>
    </div>
    <ul class="nav nav-underline">
        <li class="nav-item">
            <a class="nav-link active" href="#">Items</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../Admin-Users/ViewRegisteredUsers.php">Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../Admin-Orders/Processing.php">Orders</a>
        </li>
    </ul>
    <hr>
    <ul class="nav nav-underline">
        <li class="nav-item">
            <a class="nav-link" href="ViewItemsHomeAppliances.php">Available Items</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">Out of Stock Items</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="NewItems.php">Add New Items</a>
        </li>
    </ul>
    <hr>
    <ul class="nav nav-underline">
        <li class="nav-item">
            <a class="nav-link" href="HomeAppliancesOut.php">Home Appliances</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">Clothing</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="ElectronicsOut.php">Electronics</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="FurnituresOut.php">Furnitures</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="AccessoriesOut.php">Accessories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="SportsOut.php">Sports</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="KitchenOut.php">Kitchen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="CosmeticsOut.php">Cosmetics</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="FootwearOut.php">Footwear</a>
        </li>
    </ul>
    <hr>
    <div class="item-flex-container">
    <?php
    $host = "localhost";
    $user = "root";
    $passwd = "";
    $database = "martx";
    $tabledb = "items";
    $con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect to database");
    $query = "select * from $tabledb where itemCategory = 'Clothing' and itemQuantity = 0";
    $result = mysqli_query($con,$query);
    if($result){
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<div class='item-container'>";
                echo "<form action='EditItems.php' method='post'>";
                echo "<input type='hidden' name='id' value='{$row['itemID']}'>";
                echo "<img class='item-image' src='../Items/{$row['itemCategory']}/{$row['itemPhoto']}' alt='{$row['itemName']}'>";
                echo "<div class='item-details'>";
                echo "<p class='item-name'>ID:{$row['itemID']}</p>";
                echo "<p class='item-name'>{$row['itemName']}</p>";
                echo "<p class='item-detail'><strong>Category:</strong> {$row['itemCategory']}</p>";
                echo "<p class='item-detail'><strong>Brand:</strong> {$row['itemBrand']}</p>";
                echo "<p class='item-detail'><strong>Price:</strong> \${$row['itemPrice']}</p>";
                echo "<p class='item-detail'><strong>Quantity:</strong> Out Of Stock</p>";
                echo "<button type='submit' name='editbtn'>Edit</button>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
            }
        }else{
            echo "<div class='no-data-found'>No data found!</div>";
        }
    }else {
        echo "<script>alert('Error occuring!');</script>";
    }
    mysqli_close($con);
    ?>
    </div>
    <footer>
        <p>MartX Administration</p>
    </footer>
</body>
</html>