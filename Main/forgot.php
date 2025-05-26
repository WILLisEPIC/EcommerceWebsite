<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="L-S.css" rel="stylesheet">
    <link rel="shortcut icon" type="icon" href="../Image/martxicon.png">
    <title>MartX - Forgot Password</title>
</head>
<body>
    <div class="top">
        <div>
            <a href="Home.php"><img src="../Image/pic.png" alt="MartX" height="70px" width="140px"></a>
        </div>
        <div class="login">
            <a href="SignUp.php">Sign Up</a>
            <a href="Login.php">Log In</a>
        </div>
    </div>
    <br><br><br><br>
    <form name="forgot" method="POST">
        <center><h1>Forgot Password</h1></center>
        <br>
        <div class="input_box">
            <input type="text" placeholder="Username" name="name" autocomplete="off" required>
        </div>
        <div class="input_box">
            <input type="text" placeholder="Phone Number" name="phone" autocomplete="off" required>
        </div>
        <div class="input_box">
            <input type="text" placeholder="Email" name="email" autocomplete="off" required>
        </div>
        <p class="wrong" id="wrong"></p>
        <button type="submit" id="submitBtn">Confirm</button>
        <br>
    </form>
    <br><br><br><br><br><br><br><br>
    <footer>
        <p>&copy; 2024 MartX. All rights reserved</p>
    </footer>
    <script lang="javascript" type="text/javascript">
        document.getElementById("submitBtn").addEventListener("click", function(event) {
            restart();
        });

        function noinput(){
            document.getElementById("wrong").innerHTML = "*Input fields cannot be blank";
            document.getElementById("wrong").style.display = "block";
        }

        function incorrect(){
            document.getElementById("wrong").innerHTML = "*Incorrect information";
            document.getElementById("wrong").style.display = "block";
        }

        function restart(){
            document.getElementById("wrong").style.display = "none";
        }
    </script>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $host = "localhost";
        $user = "root";
        $passwd = "";
        $database = "martx";
        $tabledb = "user";
        $Name = $_POST['name'];
        $Phone = $_POST['phone'];
        $Email = $_POST['email'];
        if ($Name == "" || $Phone == "" || $Email == ""){
            echo "<script>noinput();</script>";
        } else{
            $con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect database");
            $query = "SELECT * FROM $tabledb WHERE BINARY Username = ? AND Phone = ? AND BINARY Email = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "sss", $Name, $Phone, $Email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
                Session_start();
                $_SESSION['FName'] = $row['Username'];
                $_SESSION['FPhone'] = $row['Phone'];
                $_SESSION['FEmail'] = $row['Email'];
                header("Location: chgpass.php");
                exit;
            }else{
                echo "<script>incorrect();</script>";
            }
            mysqli_stmt_close($stmt);
            mysqli_close($con);
        }
    }
    ?>
</body>
</html>