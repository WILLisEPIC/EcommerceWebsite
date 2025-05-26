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
    <link href="Add.css" rel="stylesheet">
    <link rel="shortcut icon" type="icon" href="../Image/martxicon.png">
    <title>MartX - Admin(Add New Items)</title>
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
            <a class="nav-link" href="HomeAppliancesOut.php">Out of Stock Items</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">Add New Items</a>
        </li>
    </ul>
    <hr><br>
    <div class="addnew">
    <form name="additems" method="POST" enctype="multipart/form-data" class="form">
        <center><h1>Add New Items</h1></center>
        <div class="input_box">
            <input type="text" placeholder="Name" name="Iname" id="Iname" value="<?php echo isset($_POST['Iname']) ? $_POST['Iname'] : ''; ?>" autocomplete="off" required>
        </div>
        <label for="category">Choose a category:</label>
        <br>
        <select name="category" id="category">
        <option value="HomeAppliances">HomeAppliances</option>
        <option value="Clothing">Clothing</option>
        <option value="Electronics">Electronics</option>
        <option value="Furnitures">Furnitures</option>
        <option value="Accessories">Accessories</option>
        <option value="Sports">Sports</option>
        <option value="Kitchen">Kitchen</option>
        <option value="Cosmetics">Cosmetics</option>
        <option value="Footwear">Footwear</option>
        </select>
        <div class="input_box">
            <input type="text" placeholder="Brand" name="brand" id="brand" value="<?php echo isset($_POST['brand']) ? $_POST['brand'] : ''; ?>" autocomplete="off" required>
        </div>
        <div class="input_box">
            <input type="text" placeholder="Price" name="price" id="price" value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>" autocomplete="off" required>
        </div>
        <p class="wrong" id="p"></p>
        <div class="input_box">
            <input type="text" placeholder="Quantity" name="quantity" id="quantity" value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'] : ''; ?>" autocomplete="off" required>
        </div>
        <p class="wrong" id="q"></p>
        <div class="input_box">
            <input type="file" name="itemphoto" id="itemphoto" accept="image/*" required>
        </div>
        <p class="wrong" id="wrong"></p>
        <br>
        <button type="button" id="submitBtn">Add</button>
        <div class="modal" id="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <p>Confirm</p>
                    <span class="close" id="close">&times;</span>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to add new item?</p>
                    <div class="modal-button">
                        <button type="submit" name="yes" id="yes">Yes</button>
                        <button type="button" id="no">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    <br>
    <footer>
        <p>MartX Administration</p>
    </footer>
    <script lang="javascript" type="text/javascript">

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById('modal').style.display = 'block';
            }
        });

        document.getElementById("submitBtn").addEventListener("click", function(event) {
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

        function price(){
            document.getElementById("p").innerHTML = "*Price must be numbers only";
            document.getElementById("p").style.display = "block";
        }

        function quantity(){
            document.getElementById("q").innerHTML = "*Quantity must be numbers only";
            document.getElementById("q").style.display = "block";
        }

        function noinput(){
            document.getElementById("wrong").innerHTML = "*Input fields cannot be null";
            document.getElementById("wrong").style.display = "block";
        }

        function noimage(){
            document.getElementById("wrong").innerHTML = "*Item's photo is required";
            document.getElementById("wrong").style.display = "block";
        }

        function restart(){
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
        if (isset($_FILES['itemphoto'])) {
            $Photo = $_FILES['itemphoto']['name'];
            $Photo_temp = $_FILES['itemphoto']['tmp_name'];
            $upload_directory = "../Items/$Category/";

            if (move_uploaded_file($Photo_temp, $upload_directory . $Photo)) {
                $query = "INSERT INTO $tabledb (itemName, itemCategory, itemBrand, itemPrice, itemQuantity, itemphoto) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "sssiis", $Name, $Category, $Brand, $Price, $Quantity, $Photo);
                
                if (mysqli_stmt_execute($stmt)) {
                    echo "<script>window.location.href = 'ViewItems$Category.php'</script>";
                } else {
                    echo "<script>alert('Failed to add new item');</script>";
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "<script>alert('Error uploading photo.');</script>";
            }
        } else {
            echo "<script>noimage();</script>";
        }
    }
    mysqli_close($con);
    }
    ?>
</body>
</html>