<?php
    session_start();
    if (!isset($_SESSION['Admin'])) {
        header("Location: ../Main/Login.php");
        exit;
    }
    $host = "localhost";
    $user = "root";
    $passwd = "";
    $database = "martx";
    $tabledb = "items";
    $ID = $_POST['id'];
    $con = mysqli_connect($host, $user, $passwd, $database) or die("Could not connect to database");
    $query = "select * from $tabledb where itemID = '$ID'";
    $result = mysqli_query($con, $query); 
    if ($result) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $iID = $row['itemID'];
        $iName = $row['itemName'];
        $iCategory = $row['itemCategory'];
        $iBrand = $row['itemBrand'];
        $iPrice = $row['itemPrice'];
        $iQuantity = $row['itemQuantity'];
        $iPhoto = $row['itemPhoto'];
    } else {
        echo "<script>alert('Error occuring!');</script>";
    }
    mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="Edit.css" rel="stylesheet">
    <link rel="shortcut icon" type="icon" href="../Image/martxicon.png">
    <title>MartX - Admin(Edit Items)</title>
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
            <a class="nav-link active" href="ViewItemsHomeAppliances.php">Available Items</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="HomeAppliancesOut.php">Out of Stock Items</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="NewItems.php">Add New Items</a>
        </li>
    </ul>
    <hr><br>
    <div class="item-flex-container">
    <div class="item-container">
        <img class="item-image" src="../Items/<?php echo $iCategory; ?>/<?php echo $iPhoto; ?>" alt="<?php echo $iName; ?>">
        <div class="item-details">
            <p class="item-name"><?php echo $iName; ?></p>
            <p class="item-detail"><strong>Category:</strong> <?php echo $iCategory; ?></p>
            <p class="item-detail"><strong>Brand:</strong> <?php echo $iBrand; ?></p>
            <p class="item-detail"><strong>Price:</strong> $<?php echo $iPrice; ?></p>
            <p class="item-detail"><strong>Quantity:</strong> <?php echo $iQuantity; ?></p>
        </div>
    </div>
    </div>
    <div class="edit">
    <form name="updateitem" method="POST" enctype="multipart/form-data">
    <center><h1>Update Item</h1></center>
    <input type="hidden" name="id" value="<?php echo $iID; ?>">
    <div class="input_box">
        <input type="text" placeholder="Name" name="Iname" id="Iname" value="<?php echo $iName; ?>" autocomplete="off">
    </div>
    <label for="category">Choose a category:</label><br>
    <select name="category" id="category">
        <?php
        $categories = array(
            "HomeAppliances",
            "Clothing",
            "Electronics",
            "Furnitures",
            "Accessories",
            "Sports",
            "Kitchen",
            "Cosmetics",
            "Footwear"
        );

        foreach ($categories as $category) {
            echo "<option value='$category'";
            if ($category == $iCategory) {
                echo " selected";
            }
            echo ">$category</option>";
        }
        ?>
    </select>
    <div class="input_box">
        <input type="text" placeholder="Brand" name="brand" id="brand" value="<?php echo $iBrand; ?>" autocomplete="off">
    </div>
    <div class="input_box">
        <input type="text" placeholder="Price" name="price" id="price" value="<?php echo $iPrice; ?>" autocomplete="off">
    </div>
    <p class="wrong" id="p"></p>
    <div class="input_box">
        <input type="text" placeholder="Quantity" name="quantity" id="quantity" value="<?php echo $iQuantity; ?>" autocomplete="off">
    </div>
    <p class="wrong" id="q"></p>
    <div class="input_box">
        <input type="file" name="itemphoto" id="itemphoto" accept="image/*">
    </div>
    <p class="wrong" id="wrong"></p>
    <div class="update"><button type="button" name="updateBtn" id="updateBtn">Update</button></div>
    <div class="modal" id="modal">
        <div class="modal-content">
            <div class="modal-header">
                <p>Confirm</p>
                <span class="close" id="close">&times;</span>
            </div>
            <div class="modal-body">
                <p>Are you sure you want update?</p>
                <div class="modal-button">
                    <button type="submit" name="yes" id="yes">Yes</button>
                    <button type="button" id="no">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    </form>
    </div>
    <br><br>
    <footer>
        <p>MartX Administration</p>
    </footer>
    <script type="text/javascript">

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById('modal').style.display = 'block';
            }
        });

        document.getElementById("updateBtn").addEventListener("click", function(event) {
            document.getElementById('modal').style.display = 'block';
        });

        document.getElementById("no").addEventListener("click", function(event) {
            document.getElementById('modal').style.display = 'none';
        });

        document.getElementById("yes").addEventListener("click", function(event) {
            document.getElementById('modal').style.display = 'none';
            restart();
        });

        document.getElementById("close").addEventListener("click", function(event) {
            document.getElementById('modal').style.display = 'none';
        });

        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                document.getElementById('modal').style.display = 'none';
            }
        });

        function price() {
            document.getElementById("p").innerHTML = "*Price must be numbers only";
            document.getElementById("p").style.display = "block";
        }

        function quantity() {
            document.getElementById("q").innerHTML = "*Quantity must be numbers only";
            document.getElementById("q").style.display = "block";
        }

        function noinput() {
            document.getElementById("wrong").innerHTML = "*Input fields cannot be null";
            document.getElementById("wrong").style.display = "block";
        }

        function noimage() {
            document.getElementById("wrong").innerHTML = "*Item's photo is required";
            document.getElementById("wrong").style.display = "block";
        }

        function restart() {
            document.getElementById("p").style.display = "none";
            document.getElementById("q").style.display = "none";
            document.getElementById("wrong").style.display = "none";
        }
    </script>
    <?php
    if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['yes'])) {
        $host = "localhost";
        $user = "root";
        $passwd = "";
        $database = "martx";
        $tabledb = "items";
        $con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect to database");
        $ID = $_POST['id'];
        $Name = $_POST['Iname'];
        $Category = $_POST['category'];
        $Brand = $_POST['brand'];
        $Price = $_POST['price'];
        $Quantity = $_POST['quantity'];
        if (empty($Name) || empty($Category) || empty($Brand) || empty($Price) || $Quantity == ""){
            echo "<script>noinput();</script>";
        } else if (!is_numeric($Price)){
            echo "<script>price();</script>";
        }else if (!is_numeric($Quantity)){
            echo "<script>quantity();</script>";
        } else {
            if (isset($_FILES['itemphoto']) && $_FILES['itemphoto']['error'] == UPLOAD_ERR_OK) {
                $Photo = $_FILES['itemphoto']['name'];
                $Photo_temp = $_FILES['itemphoto']['tmp_name'];
                $upload_directory = "../Items/$Category/";
                if (move_uploaded_file($Photo_temp, $upload_directory . $Photo)) {
                    $query = "UPDATE $tabledb SET itemName = ?, itemCategory = ?, itemBrand = ?, itemPrice = ?, itemQuantity = ?, itemPhoto = ? WHERE itemID = ?";
                    $stmt = mysqli_prepare($con, $query);
                    mysqli_stmt_bind_param($stmt, "sssiisi", $Name, $Category, $Brand, $Price, $Quantity, $Photo, $ID);
                } else {
                    echo "<script>alert('Failed to move uploaded file');</script>";
                    exit;
                }
            } else {
                $query = "UPDATE $tabledb SET itemName = ?, itemCategory = ?, itemBrand = ?, itemPrice = ?, itemQuantity = ? WHERE itemID = ?";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "sssiii", $Name, $Category, $Brand, $Price, $Quantity, $ID);
            }
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>window.location.href = 'ViewItems$Category.php';</script>";
            } else {
                echo "<script>alert('Failed to update item!');</script>";
            }
        
            mysqli_stmt_close($stmt);
        }
        mysqli_close($con);
    }
    ?>
</body>
</html>