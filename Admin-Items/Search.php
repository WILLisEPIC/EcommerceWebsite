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
    <title>MartX - Admin Item Search(<?php echo $_GET['search']; ?>)</title>
</head>
<body>
    <div class="top">
    <img src="../Image/pic.png" alt="MartX" height="70px" width="140px">
        <div>
            <form class="search-form">
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
            <a class="nav-link" href="../Admin-Items/ViewItemsHomeAppliances.php">Items</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../Admin-Users/ViewRegisteredUsers.php">Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../Admin-Orders/Processing.php">Orders</a>
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
    $sql = "SELECT * FROM $tabledb WHERE itemID LIKE '%$key%' OR itemName LIKE '%$key%' OR itemCategory LIKE '%$key%' OR itemBrand LIKE '%$key%'";
    $result = mysqli_query($con,$sql);
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
                echo "<p class='item-detail'><strong>Quantity:</strong> {$row['itemQuantity']}</p>";
                echo "<button type='submit' name='editbtn'>Edit</button>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
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