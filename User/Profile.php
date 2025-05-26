<?php
session_start();
if (!isset($_SESSION['ID'])) {
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
    <link href="Profile.css" rel="stylesheet">
    <link rel="shortcut icon" type="icon" href="../Image/martxicon.png">
    <title>MartX - (Your Information)</title>
</head>
<body>

    <?php
        if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['yes'])){
        $host = "localhost";
        $user = "root";
        $passwd = "";
        $database = "martx";
        $tabledb = "user";
        $ID = $_POST['id'];
        $Name = $_POST['name'];
        $Address = $_POST['address'];
        $DOB = $_POST['dob'];
        $con = mysqli_connect($host, $user, $passwd, $database) or die("Could not connect database");
        $query = "UPDATE $tabledb set Username = ?, Address = ?, DOB = ? WHERE UserID = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $Name, $Address, $DOB, $ID);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Information Updated!');</script>";
        } else {
            echo "<script>alert('Failed to update information');</script>";
        }
        mysqli_stmt_close($stmt);
        }
        $USERID = $_SESSION['ID'];
        $host = "localhost";
        $user = "root";
        $passwd = "";
        $database = "martx";
        $tabledb = "user";
        $con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect to the database");
        $query = "SELECT Username, Phone, Email, Address, DOB from $tabledb where UserID = $USERID";
        $result = mysqli_query($con,$query);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $USERNAME = $row['Username'];
        $PHONE = $row['Phone'];
        $EMAIL = $row['Email'];
        $ADDRESS = $row['Address'];
        $DOB = $row['DOB'];
        $cartquery = "SELECT * FROM cartitems where cartID = '$USERID'";
        $carttotal = mysqli_query($con, $cartquery);
        if($carttotal){
            $cartItemsCount = mysqli_num_rows($carttotal);
        }else{
            echo "Error";
        }
        mysqli_close($con);
    ?>
    <div class="top">
        <div>
            <a href="Home.php"><img src="../Image/pic.png" alt="MartX" height="70px" width="140px"></a>
        </div>
        <div>
            <h1>Your Information</h1>
        </div>
        <div class="login">
            <button id="orderhistory">Order History</button>
            <span class="cart-count"><?php echo $cartItemsCount ?></span>
            <a href="../Cart/Cart.php" class="cart-link"><img src="../Image/cart.png" width="24px" height="20px"></a>
            <a href="../Main/destroy_session.php">Log Out</a>
        </div>
    </div>
    <br>
    <div id="order-history" class="order-history-container">
        <?php
            $ordertable = "orders";
            $detailtable = "orderdetails";
            $itemtable = "items";
            $con = mysqli_connect($host, $user, $passwd, $database) or die("Could not connect database");
            $order = "SELECT * FROM $ordertable where UserID = '".$USERID."' ORDER BY orderID DESC";
            $orderRESULT = mysqli_query($con,$order);
            if($orderRESULT){
                echo "<table border='0'>";
                echo "<th>Order ID<th>Order Date<th>Item Name<th>Quantity<th>Total Price<th>Deliverable Address<th>Order Status";
                while($rowORDER = mysqli_fetch_array($orderRESULT, MYSQLI_ASSOC)){
                    $OID = $rowORDER['orderID'];
                    $Odate = $rowORDER['orderDate'];
                    $Ostatus = $rowORDER['orderStatus'];
                    $Oaddress = $rowORDER['deliverAddress'];
                    $detail = "SELECT * FROM $detailtable where orderID = '".$OID."'";
                    $detailRESULT = mysqli_query($con, $detail);
                    
                    while($rowDETAIL = mysqli_fetch_array($detailRESULT, MYSQLI_ASSOC)){
                        $itemID = $rowDETAIL['itemID'];
                        $quantity = $rowDETAIL['quantity'];

                        $ITEM = "SELECT * FROM $itemtable WHERE itemID = '".$itemID."'";
                        $itemRESULT = mysqli_query($con, $ITEM);
                        $rowITEM = mysqli_fetch_array($itemRESULT, MYSQLI_ASSOC);
                        $itemNAME = $rowITEM['itemName'];
                        $itemPRICE = $rowITEM['itemPrice'];

                        $totalprice = $itemPRICE * $quantity;
                        echo "<tr>";
                        echo "<td>" . $OID . "</td>";
                        echo "<td>" . $Odate . "</td>";
                        echo "<td>" . $itemNAME . "</td>";
                        echo "<td>" . $quantity . "</td>";
                        echo "<td>$" . $totalprice . "</td>";
                        echo "<td>" . $Oaddress . "</td>";
                        echo "<td>" . $Ostatus . "</td>";
                        echo "</tr>";
                    }
                }
                echo "</table>";
            }else{
                echo "Error!";
            }
            mysqli_close($con);
        ?>
    </div>
    <form method="POST" onsubmit="return validateForm();">
        <input type="hidden" name="id" value="<?php echo $_SESSION['ID']; ?>">
        <div class="input_box">
            <label for="name">Username: </label>
            <input type="text" name="name" id="name" value="<?php echo $USERNAME; ?>" autocomplete="off">
        </div>
        <div class="input_box">
            <label for="phone">Phone: </label>
            <input type="text" name="phone" value="<?php echo $PHONE; ?>" disabled>
        </div>
        <div class="input_box">
            <label for="email">Email: </label>
            <input type="text" name="email" value="<?php echo $EMAIL; ?>" disabled>
        </div>
        <div class="input_box">
            <label for="address">Address: </label>
            <textarea rows="4" name="address" id="address" ><?php echo $ADDRESS; ?></textarea>
        </div>
        <div class="input_box">
            <label for="dob">Date of Birth: </label>
            <input type="date" name="dob" id="dob" value="<?php echo $DOB; ?>" autocomplete="off">
        </div>
        <p class="wrong" id="error"></p> 
        <button type="button" name="update" id="update" >Update</button>
        <div class="modal" id="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <p>Confirm</p>
                    <span class="close" id="close">&times;</span>
                </div>
                <div class="modal-body">
                    <p>Are you sure you?</p>
                    <div class="modal-button">
                        <button type="submit" name="yes" id="yes">Yes</button>
                        <button type="button" id="no">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <br><br><br><br>
    <footer>
        <p>&copy; 2024 MartX. All rights reserved</p>
    </footer>
    <script lang="javascript" type="text/javascript">

        function noinput() {
            document.getElementById("error").innerHTML = "*Input fields cannot be blank";
            document.getElementById("error").style.display = "block";
        }

        function restart() {
            document.getElementById("error").style.display = "none";
        }

        function validateForm() {
            var name = document.getElementById('name').value;
            var address = document.getElementById('address').value;
            var dob = document.getElementById('dob').value;

            if (name.trim() === "" || address.trim() === "" || dob.trim() === "") {
                noinput();
                return false;
            }
            restart();
            return true;
        }

        document.getElementById("update").addEventListener("click", function(event) {
            document.getElementById('modal').style.display = 'block';
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById('modal').style.display = 'block';
            }
        });

        document.getElementById("no").addEventListener("click", function(event) {
            document.getElementById('modal').style.display = 'none';
        });

        document.getElementById("yes").addEventListener("click", function(event) {
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

        document.getElementById("orderhistory").addEventListener("click", function(event) {
            event.stopPropagation();
            document.getElementById("order-history").style.display = "block";
        });

        document.body.addEventListener("click", function(event) {
            if (event.target.id !== "orderhistory") {
                document.getElementById("order-history").style.display = "none";
            }
        });
    </script>
</body>
</html>