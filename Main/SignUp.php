<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="L-S.css" rel="stylesheet">
    <link rel="shortcut icon" type="icon" href="../Image/martxicon.png">
    <title>MartX - Sign Up</title>
</head>
<body>
    <div class="top">
        <div>
            <a href="Home.php"><img src="../Image/pic.png" alt="MartX" height="70px" width="140px"></a>
        </div>
        <div class="login">
            <a href="#" class="current">Sign Up</a>
            <a href="Login.php">Log In</a>
        </div>
    </div>
    <br>
    <form name="signup" method="POST">
        <center><h1>Sign Up</h1></center>
        <div class="input_box">
            <input type="text" placeholder="Username" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" autocomplete="off" required>
        </div>
        <div class="input_box">
            <input type="text" placeholder="Phone Number" name="phone" id="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" autocomplete="off" required>
        </div>
        <p class="wrong" id="ph"></p>
        <div class="input_box">
            <input type="email" placeholder="Email" name="email" id="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" autocomplete="off" required>
        </div>
        <p class="wrong" id="e"></p> 
        <div class="input_box">
            <textarea name="address" rows="4" placeholder="Address (current)" required><?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?></textarea>
        </div>
        <div class="input_box">
            <label for="dob">Date of Birth: </label>
            <input type="date" name="dob" id="dob" value="<?php echo isset($_POST['dob']) ? $_POST['dob'] : ''; ?>" max="<?php echo date("Y-m-d"); ?>" required>
        </div>
        <div class="input_box">
            <input type="password" placeholder="Password" id="pass" name="pass" value="<?php echo isset($_POST['pass']) ? $_POST['pass'] : ''; ?>" required>
        </div>
        <div class="input_box">
            <input type="password" placeholder="Confirm Password" id="confirmpass" name="confirmpass" value="<?php echo isset($_POST['confirmpass']) ? $_POST['confirmpass'] : ''; ?>" required>
        </div>
        <p class="wrong" id="password"></p> 
        <div class="show">
            <input type="checkbox" id="showpass">Show Password
        </div>
        <button type="button" id="submitBtn">Register</button>
        <div class="modal" id="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <p>Confirm</p>
                    <span class="close" id="close">&times;</span>
                </div>
                <div class="modal-body">
                    <p>Are you sure about your information?</p>
                    <div class="modal-button">
                        <button type="submit" name="yes" id="yes">Yes</button>
                        <button type="button" id="no">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <br><br><br>
    <script lang="javascript" type="text/javascript">
        var showPassCheckbox = document.getElementById("showpass");
        var passwordInput = document.getElementById("pass");
        var confirmpasswordInput = document.getElementById("confirmpass");

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

        showPassCheckbox.addEventListener("change", function () {
            passwordInput.type = this.checked ? "text" : "password";
            confirmpasswordInput.type = this.checked ? "text" : "password";
        });

        var phone, email;

        function Aphone(phone){
            document.getElementById("ph").innerHTML = "*"+phone+" has been already registered";
            document.getElementById("ph").style.display = "block";
        }

        function invalidph(phone){
            document.getElementById("ph").innerHTML = "*"+phone+" is an invalid phone number";
            document.getElementById("ph").style.display = "block";
        }

        function Aemail(email){
            document.getElementById("e").innerHTML = "*"+email+" has been already registered";
            document.getElementById("e").style.display = "block";
        }

        function invalidemail(email){
            document.getElementById("e").innerHTML = "*"+email+" is an invalid email";
            document.getElementById("e").style.display = "block";
        }

        function samepw(){
            document.getElementById("password").innerHTML = "*Passwords are not the same";
            document.getElementById("password").style.display = "block";
        }

        function noinput(){
            document.getElementById("password").innerHTML = "*Input fields cannot be blank";
            document.getElementById("password").style.display = "block";
        }

        function block(){
            document.getElementById("password").innerHTML = "*You are blocked";
            document.getElementById("password").style.display = "block";
        }

        function restart(){
            document.getElementById("ph").style.display = "none";
            document.getElementById("e").style.display = "none";
            document.getElementById("password").style.display = "none";
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
        $Name = $_POST['name'];
        $Phone = $_POST['phone'];
        $Email = $_POST['email'];
        $Address = $_POST['address'];
        $DOB = $_POST['dob'];
        $Password = $_POST['pass'];
        $CPassword = $_POST['confirmpass'];
        $con = mysqli_connect($host, $user, $passwd, $database) or die("Could not connect database");
        $query = "SELECT * FROM $tabledb WHERE Phone = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $Phone);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $query2 = "SELECT * FROM $tabledb WHERE BINARY Email = ?";
        $stmt2 = mysqli_prepare($con, $query2);
        mysqli_stmt_bind_param($stmt2, "s", $Email);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);

        $query3 = "SELECT * FROM $tabledb WHERE (Phone = ? OR BINARY Email = ?) AND blockStatus = 1";
        $stmt3 = mysqli_prepare($con, $query3);
        mysqli_stmt_bind_param($stmt3, "ss", $Phone, $Email);
        mysqli_stmt_execute($stmt3);
        $result3 = mysqli_stmt_get_result($stmt3);
        
        if ($Name == "" || $Phone == "" || $Email == "" || $Address == "" || $DOB == "" || $Password == "" || $CPassword == "") {
            echo "<script>noinput();</script>";
        } else if (!preg_match("/^[0-9]{9,11}$/", $Phone)) {
            echo "<script>invalidph('$Phone');</script>";
        } else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>invalidemail('$Email');</script>";
        } else if ($Password != $CPassword) {
            echo "<script>samepw();</script>";
        } else if (mysqli_num_rows($result3) > 0) {
            echo "<script>block();</script>";
        }else if (mysqli_num_rows($result) > 0) {
            echo "<script>Aphone('$Phone'); document.getElementById('phone').value = '';</script>";
        } else if (mysqli_num_rows($result2) > 0) {
            echo "<script>Aemail('$Email'); document.getElementById('email').value = '';</script>";
        } else {
            $sql = "INSERT INTO $tabledb (Username, Phone, Email, Address, DOB, Password) VALUES (?, ?, ?, ?, ?, ?)";
            $insert = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($insert, "ssssss", $Name, $Phone, $Email, $Address, $DOB, $Password);
            if (mysqli_stmt_execute($insert)) {
                $id = $con->insert_id;
                $cartQ = "INSERT INTO cart (cartID, UserID) VALUES (?,?)";
                $cart = mysqli_prepare($con,$cartQ);
                mysqli_stmt_bind_param($cart, "ii", $id, $id);
                if (mysqli_stmt_execute($cart)) {
                    echo "<script>window.location.href = 'Login.php';</script>";
                }else{
                    echo "<script>alert('Registration Failed!');</script>";
                }
            } else {
                echo "<script>alert('Registration Failed!');</script>";
            }
            mysqli_stmt_close($insert);
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt2);
        mysqli_close($con);
    }
    ?>
</body>
</html>