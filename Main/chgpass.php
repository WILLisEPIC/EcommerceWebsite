<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="L-S.css" rel="stylesheet">
    <link rel="shortcut icon" type="icon" href="../Image/martxicon.png">
    <title>MartX - Change Password</title>
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
        <center><h1>Change Password</h1></center>
        <br>
        <div class="input_box">
            <input type="text" placeholder="New Password" name="newpass" autocomplete="off" required>
        </div>
        <div class="input_box">
            <input type="text" placeholder="Confirm Password" name="confirmpass" autocomplete="off" required>
        </div>
        <p class="wrong" id="error"></p>
        <button type="button" id="confirm">Confirm</button>
        <br>
        <div class="modal" id="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <p>Confirm</p>
                    <span class="close" id="close">&times;</span>
                </div>
                <div class="modal-body">
                    <p>Are you sure?</p>
                    <div class="modal-button">
                        <button type="submit" name="yes" id="yes">Yes</button>
                        <button type="button" id="no">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <br><br><br><br><br><br><br><br><br><br><br>
    <footer>
        <p>&copy; 2024 MartX. All rights reserved</p>
    </footer>
    <script>
        document.getElementById("confirm").addEventListener("click", function(event) {
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

        document.getElementById("close").addEventListener("click", function(event) {
            document.getElementById('modal').style.display = 'none';
        });

        document.getElementById("yes").addEventListener("click", function(event) {
            document.getElementById('modal').style.display = 'none';
            restart();
        });

        function noinput(){
            document.getElementById("error").innerHTML = "*Input fields cannot be blank";
            document.getElementById("error").style.display = "block";
        }

        function incorrect(){
            document.getElementById("error").innerHTML = "*Passwords are not the same";
            document.getElementById("error").style.display = "block";
        }

        function restart(){
            document.getElementById("error").style.display = "none";
        }
    </script>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $host = "localhost";
        $user = "root";
        $passwd = "";
        $database = "martx";
        $tabledb = "user";
        Session_start();
        $Name = $_SESSION['FName'];
        $Phone = $_SESSION['FPhone'];
        $Email = $_SESSION['FEmail'];
        $NewPass = $_POST['newpass'];
        $ConfirmPass = $_POST['confirmpass'];
        if($NewPass == "" || $ConfirmPass == ""){
            echo "<script>noinput();</script>";
        } else if($NewPass != $ConfirmPass){
            echo "<script>incorrect();</script>";
        }else{
            $con = mysqli_connect($host,$user,$passwd,$database) or die("Could not connect database");
            $query = "UPDATE $tabledb set Password = ? WHERE Username = ? AND Phone = ? AND Email = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "ssss",$NewPass, $Name, $Phone, $Email);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Password Updated!'); window.location.href = 'Login.php'</script>";
            } else {
                echo "<script>alert('Failed!');</script>";
            }
            mysqli_stmt_close($stmt);
            mysqli_close($con);
        }
    }
    ?>
</body>
</html>