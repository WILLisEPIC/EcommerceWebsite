<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="L-S.css" rel="stylesheet">
    <link rel="shortcut icon" type="icon" href="../Image/martxicon.png">
    <title>MartX - Login</title>
</head>
<body>
    <div class="top">
        <div>
            <a href="Home.php"><img src="../Image/pic.png" alt="MartX" height="70px" width="140px"></a>
        </div>
        <div class="login">
            <a href="SignUp.php">Sign Up</a>
            <a href="#" class="current">Log In</a>
        </div>
    </div>
    <br><br><br><br>
    <form name="login" method="POST" class="gg">
        <center><h1>Login</h1></center>
        <div class="input_box">
            <input type="text" placeholder="Email" name="email" autocomplete="off" required>
        </div>
        <div class="input_box">
            <input type="password" placeholder="Password" id="pass" name="pass" required>
        </div>
        <p class="wrong" id="wrong"></p>
        <div class="show">
            <input type="checkbox" id="showpass">Show Password
        </div>
        <button type="submit" id="submitBtn">Login</button>
        <br><br>
        <div class="forgot">
            <a href="forgot.php">forgot password?</a>
        </div>
    </form>
    <br><br><br><br><br><br><br><br><br><br>
    <script lang="javascript" type="text/javascript">
        var showPassCheckbox = document.getElementById("showpass");
        var passwordInput = document.getElementById("pass");

        showPassCheckbox.addEventListener("change", function () {
            passwordInput.type = this.checked ? "text" : "password";
        });

        document.getElementById("submitBtn").addEventListener("click", function(event) {
            restart();
        });
        
        function noinput(){
            document.getElementById("wrong").innerHTML = "*Input fields cannot be null";
            document.getElementById("wrong").style.display = "block";
        }

        function incorrect(){
            document.getElementById("wrong").innerHTML = "*Incorrect Username or Password";
            document.getElementById("wrong").style.display = "block";
        }

        function block(){
            document.getElementById("wrong").innerHTML = "*You are blocked";
            document.getElementById("wrong").style.display = "block";
        }

        function restart(){
            document.getElementById("wrong").style.display = "none";
        }
    </script>
    <footer>
        <p>&copy; 2024 MartX. All rights reserved</p>
    </footer>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $host = "localhost";
        $user = "root";
        $passwd = "";
        $database = "martx";
        $tabledb = "user";
        $tabledb2 = "admin";
        $Email = $_POST['email'];
        $Password = $_POST['pass'];
        if($Email == "" || $Password == ""){
            echo "<script>noinput();</script>";
        } else{
            $con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect database");
            $query = "SELECT * FROM $tabledb WHERE BINARY Email = ? AND BINARY Password = ? AND blockStatus = 0";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "ss", $Email, $Password);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $query2 = "SELECT * FROM $tabledb2 WHERE BINARY Name = ? AND BINARY Password = ?";
            $stmt2 = mysqli_prepare($con, $query2);
            mysqli_stmt_bind_param($stmt2, "ss", $Email, $Password);
            mysqli_stmt_execute($stmt2);
            $result2 = mysqli_stmt_get_result($stmt2);

            $query3 = "SELECT * FROM $tabledb WHERE BINARY Email = ? AND BINARY Password = ? AND blockStatus = 1";
            $stmt3 = mysqli_prepare($con, $query3);
            mysqli_stmt_bind_param($stmt3, "ss", $Email, $Password);
            mysqli_stmt_execute($stmt3);
            $result3 = mysqli_stmt_get_result($stmt3);

            if(mysqli_num_rows($result2) > 0){
                $row2 = mysqli_fetch_assoc($result2);
                session_start();
                $_SESSION['Admin'] = $row2['Name'];
                header("Location: ../Admin-Items/ViewItemsHomeAppliances.php");
                exit;
            } else if(mysqli_num_rows($result3) > 0){
                echo "<script>block();</script>";
            }else if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
                session_start();
                $_SESSION['ID'] = $row['UserID'];
                header("Location: ../User/Home.php");
                exit;
            }  else{
                echo "<script>incorrect();</script>";
            }
            mysqli_stmt_close($stmt);
            mysqli_stmt_close($stmt2);
            mysqli_stmt_close($stmt3);
            mysqli_close($con);
        }
    }
    ?>
</body>
</html>