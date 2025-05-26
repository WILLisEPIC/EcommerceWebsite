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
    <link href="AdminOrder.css" rel="stylesheet">
    <link rel="shortcut icon" type="icon" href="../Image/martxicon.png">
    <title>MartX - Admin(Delivering Orders)</title>
</head>
<body>
    <div class="top">
        <img src="../Image/pic.png" alt="MartX" height="70px" width="140px">
        <div>
            <form class="search-form" action="Search.php">
                <input type="text" id="search" name="search" placeholder="Search by order ID and User ID...">
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
            <a class="nav-link active" href="#">Orders</a>
        </li>
    </ul>
    <hr>
    <ul class="nav nav-underline">
        <li class="nav-item">
            <a class="nav-link" href="Processing.php">Processing Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">Delivering Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Delivered.php">Delivered Orders</a>
        </li>
    </ul>
    <hr>
    <?php
    $host = "localhost";
    $user = "root";
    $passwd = "";
    $database = "martx";
    $orderdb = "orders";
    $detailsdb = "orderdetails";
    $itemdb = "items";
    $userdb = "user";
    $GRAND = 0;
    $con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect to database");
    if(($_SERVER['REQUEST_METHOD']=="POST") && isset($_POST['processing'])){
        $ID = $_POST['ID'];
        $processQUERY = "UPDATE $orderdb SET orderStatus = 'processing' WHERE orderID = '".$ID."'";
        $processRESULT = mysqli_query($con, $processQUERY);
        if($processRESULT){
            echo "<script>window.location.href='Processing.php';</script>";
        }else{
            echo "<script>alert('Error!')</script>";
        }
    }

    if(($_SERVER['REQUEST_METHOD']=="POST") && isset($_POST['delivering'])){
        $ID = $_POST['ID'];
        $deliveringQUERY = "UPDATE $orderdb SET orderStatus = 'delivering' WHERE orderID = '".$ID."'";
        $deliveringRESULT = mysqli_query($con, $deliveringQUERY);
        if($deliveringRESULT){
            echo "<script>window.location.href='Delivering.php';</script>";
        }else{
            echo "<script>alert('Error!')</script>";
        }
    }

    if(($_SERVER['REQUEST_METHOD']=="POST") && isset($_POST['delivered'])){
        $ID = $_POST['ID'];
        $deliveredQUERY = "UPDATE $orderdb SET orderStatus = 'delivered' WHERE orderID = '".$ID."'";
        $deliveredRESULT = mysqli_query($con, $deliveredQUERY);
        if($deliveredRESULT){
            echo "<script>window.location.href='Delivered.php';</script>";
        }else{
            echo "<script>alert('Error!')</script>";
        }
    }
    $orderQUERY = "select * from $orderdb where orderStatus = 'delivering' ORDER BY orderID DESC";
    $orderRESULT = mysqli_query($con, $orderQUERY);
    if($orderRESULT){
        $row_count = mysqli_num_rows($orderRESULT);
        if ($row_count > 0) {
            echo "<table border=0>";
            echo "<th>Order ID<th>User ID<th>Username<th>Date<th>Address<th>Status<th><th>";
            while($orderROW = mysqli_fetch_array($orderRESULT, MYSQLI_ASSOC)){
                $OrderID = $orderROW['orderID'];
                $UserID = $orderROW['UserID'];
                $orderSTATUS = $orderROW['orderStatus'];
                $orderDATE = $orderROW['orderDate'];
                $orderADDRESS = $orderROW['deliverAddress'];

                $userQUERY = "SELECT Username FROM $userdb WHERE UserID = '".$UserID."'";
                $userRESULT = mysqli_query($con, $userQUERY);
                if($userRESULT){
                    $userROW = mysqli_fetch_array($userRESULT, MYSQLI_ASSOC);
                    $Username = $userROW['Username'];
                }

                $GRAND = 0;
                echo "<tr>";
                echo "<form method='POST'>";
                echo "<td><input type='text' name='ID' readonly style='border: none; background-color: transparent;' value='$OrderID'></td>";
                echo "<td>$UserID</td>";
                echo "<td>$Username</td>";
                echo "<td>$orderDATE</td>";
                echo "<td>$orderADDRESS</td>";
                echo "<td>$orderSTATUS</td>";
                echo "<td><button type='button' name='detail' id='detail'>Detail</button></td>";
                echo "<td><button type='button' name='change' onclick='showModal($OrderID)'>Change</button></td>";
                echo "</form>";
                echo "</tr>";

                echo "<div class='modal' id='modal_$OrderID'>";
                echo "<div class='modal-content'>";
                echo "<div class='modal-header'>";
                echo "<p>Confirm</p>";
                echo "<span class='close' onclick='closeModal($OrderID)'>&times;</span>";
                echo "</div>";
                echo "<div class='modal-body'>";
                echo "<p>Please choose the status option that you want to change.</p>";
                echo "<div class='modal-button'>";
                echo "<button type='submit' name='processing' onclick='submitForm(\"processing\", $OrderID)'>Processing</button>";
                echo "<button type='submit' name='delivering' onclick='submitForm(\"delivering\", $OrderID)'>Delivering</button>";
                echo "<button type='submit' name='delivered' onclick='submitForm(\"delivered\", $OrderID)'>Delivered</button>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

                echo "<tr style='display: none;'>";
                echo "<td colspan='8'>";

                echo "<table border='1' class='order_detail'>";
                echo "<tr>";
                echo "<th colspan='8' style='text-align: center;'>$Username's Order Details</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<th colspan='2'>Order Item</th><th colspan='2'>Order Quantity</th><th colspan='2'>Item Unit Price</th><th colspan='2'>Total Price</th>";
                echo "</tr>";
            
                $detailsQUERY = "SELECT * FROM $detailsdb WHERE orderID = '$OrderID'";
                $detailsRESULT = mysqli_query($con, $detailsQUERY);
            
                if ($detailsRESULT) {
                    while ($detailsROW = mysqli_fetch_array($detailsRESULT, MYSQLI_ASSOC)) {
                        $ItemID = $detailsROW['itemID'];
                        $Quantity = $detailsROW['quantity'];
            
                        $itemQUERY = "SELECT * FROM $itemdb WHERE itemID = '$ItemID'";
                        $itemRESULT = mysqli_query($con, $itemQUERY);
            
                        if ($itemRESULT) {
                            $itemROW = mysqli_fetch_array($itemRESULT, MYSQLI_ASSOC);
                            $ItemName = $itemROW['itemName'];
                            $ItemPrice = $itemROW['itemPrice'];
                            $Total = $Quantity * $ItemPrice;
                            
                            echo "<tr>";
                            echo "<td colspan='2'>$ItemName</td>";
                            echo "<td colspan='2'>$Quantity</td>";
                            echo "<td colspan='2'>$ItemPrice</td>";
                            echo "<td colspan='2'>$Total</td>";
                            echo "</tr>";
                        }
                        $GRAND += $Total;
                    }
                    echo "<tr>";
                    echo "<td colspan='4'></td>";
                    echo "<td colspan='2'><strong>Grand Total :</strong></td>";
                    echo "<td colspan='2'><strong>$GRAND</strong></td>";
                    echo "</tr>";
                }
                echo "</table>";
            
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }else{
            echo "<div class='no-data-found'>No data found!</div>";
        }
    }
    mysqli_close($con);
    ?>
    <footer>
        <p>MartX Administration</p>
    </footer>
    <script type="text/javascript">
        function showModal(orderID) {
            const modal = document.getElementById(`modal_${orderID}`);
            modal.style.display = 'block';
        }

        function closeModal(orderID) {
            const modal = document.getElementById(`modal_${orderID}`);
            modal.style.display = 'none';
        }

        function submitForm(action, orderID) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = ''; // Specify the form action URL
            form.innerHTML = `<input type="hidden" name="ID" value="${orderID}">
                              <input type="hidden" name="${action}" value="1">`;
            document.body.appendChild(form);
            form.submit();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const detailButtons = document.querySelectorAll('[name="detail"]');
            
            detailButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const orderDetailRow = button.closest('tr').nextElementSibling;
                    
                    if (orderDetailRow.style.display === 'none' || orderDetailRow.style.display === '') {
                        orderDetailRow.style.display = 'table-row';
                    } else {
                        orderDetailRow.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>