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
    <title>MartX - Admin User Search(<?php $_GET['search']; ?>)</title>
</head>
<body>
    <div class="top">
        <img src="../Image/pic.png" alt="MartX" height="70px" width="140px">
        <div>
            <form class="search-form">
                <input type="text" id="search" name="search" placeholder="Search by ID, Name, Phone, Email, Address, DOB...">
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
            <a class="nav-link" href="ViewRegisteredUsers.php">Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../Admin-Orders/Processing.php">Orders</a>
        </li>
    </ul>
    <hr>
    <ul class="nav nav-underline">
        <li class="nav-item">
            <a class="nav-link" href="ViewRegisteredUsers.php">Registered Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="ViewBlockededUsers.php">Blocked Users</a>
        </li>
    </ul>
    <hr>
    <h3>Users related with - <?php echo $_GET['search']; ?></h3>
    <?php
    $host = "localhost";
    $user = "root";
    $passwd = "";
    $database = "martx";
    $tabledb = "user";
    $key = $_GET['search'];
    if($key == ""){
        echo "<div class='no-data-found'>No data found!</div>";
        exit;
    }
    $con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect to database");
    $sql = "SELECT * FROM $tabledb WHERE userID LIKE '%$key%' OR Username LIKE '%$key%' OR Phone LIKE '%$key%' OR Address LIKE '%$key%' OR Email LIKE '%$key%' OR DOB LIKE '%$key%'";
    if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['unblock'])) {
        $ID = $_POST['ID'];
        $Name = $_POST['Name'];
        $query = "UPDATE $tabledb SET blockStatus = 0 WHERE UserID = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $ID);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('$Name is unblocked!');</script>";
        } else {
            echo "<script>alert('Error blocking $Name');</script>";
        }
        mysqli_stmt_close($stmt);
    }
    if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['block'])) {
        $ID = $_POST['ID'];
        $Name = $_POST['Name'];
        $query = "UPDATE $tabledb SET blockStatus = 1 WHERE UserID = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $ID);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('$Name is blocked!');</script>";
        } else {
            echo "<script>alert('Error blocking $Name');</script>";
        }
        mysqli_stmt_close($stmt);
    }
    $result = mysqli_query($con,$sql);
    if($result){
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            echo "<table border=1>";
            echo "<th>ID<th>Name<th>Phone<th>Email<th>Address<th>Date of Birth<th>";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<tr>";
                echo "<form method='POST'>";
                foreach ($row as $key => $value) {
                    if($key == "UserID"){
                        echo "<td><input type='text' name='ID' readonly style='border: none; background-color: transparent;' value='$value'></td>";
                    }else if($key == "Username"){
                        echo "<td><input type='text' name='Name' readonly style='border: none; background-color: transparent;' value='$value'></td>";
                    }else if($key == "Phone"){
                        echo "<td><input type='text' name='Phone' readonly style='border: none; background-color: transparent;' value='$value'></td>";
                    }else if($key == "Email"){
                        echo "<td><input type='text' name='Email' readonly style='border: none; background-color: transparent; width: 100%;' value='$value'></td>";
                    }else if($key == "Address"){
                        echo "<td><input type='text' name='Address' readonly style='border: none; background-color: transparent;' value='$value'></td>";
                    }else if($key == "DOB"){
                        echo "<td><input type='text' name='DOB' readonly style='border: none; background-color: transparent;' value='$value'></td>";
                    }else if($key == "blockStatus"){
                        $status = $value;
                    }
                }
                if($status == "1"){
                    echo "<td><button type='submit' id='unblock' name='unblock' class='unblock-btn'>Unblock</button></td>";
                }else{
                    echo "<td><button type='submit' id='block' name='block' class='block-btn'>Block</button></td>";
                }
                echo "</form>";
                echo "</tr>";
            }
            echo "</table>";
        }else{
            echo "<div class='no-data-found'>No data found!</div>";
        }
    }else {
        echo "<script>alert('Error occuring!');</script>";
    }
    mysqli_close($con);
    ?>
    <footer>
        <p>MartX Administration</p>
    </footer>
    <script type="text/javascript">
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const blockButtons = document.querySelectorAll('.unblock-btn');

            blockButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    const confirmation = confirm('Are you sure you want to unblock this user?');
                    if (!confirmation) {
                        event.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>