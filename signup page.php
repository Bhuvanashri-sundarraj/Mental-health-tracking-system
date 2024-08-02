<?php
$success = 0;
$user = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $city = $_POST['city'];
    $country = $_POST['country'];

    // Use prepared statements to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM registration WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $num = $result->num_rows;
        if ($num > 0) {
            $user = 1;
        } else {
            // Hash the password before storing it
            
            $stmt = $con->prepare("INSERT INTO registration (username, password, email, phone, gender, age, city, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $username, $password, $email, $phone, $gender, $age, $city, $country);
            $result = $stmt->execute();

            if ($result) {
                // Redirect to homepage upon successful signup
                header('Location: homepage 01.html');
                exit();
            } else {
                die($con->error);
            }
        }
    }
    $stmt->close();
    $con->close();

    // Clear POST data after form submission
    $_POST = array();
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Signup Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function validatePassword() {
            var password = document.getElementById("password").value;
            var message = "";

            if (password.length < 8) {
                message = "Password must be at least 8 characters long.";
            } else if (!/[A-Z]/.test(password)) {
                message = "Password must contain at least one uppercase letter.";
            } else if (!/[a-z]/.test(password)) {
                message = "Password must contain at least one lowercase letter.";
            } else if (!/[0-9]/.test(password)) {
                message = "Password must contain at least one digit.";
            } else if (!/[!@#$%^&*]/.test(password)) {
                message = "Password must contain at least one special character.";
            }

            document.getElementById("passwordMessage").innerHTML = message;
            return message === "";
        }

        function validateForm() {
            return validatePassword() && validcap();
        }
    </script>
    <style>
        /* Your CSS styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #080710;
            color: #ffffff;
        }

        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .video-bg video {
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .content {
            position: relative;
            z-index: 1;
            padding: 20px;
            text-align: center;
            color: white;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .main {
            width: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.5) 50%);
            background-position: center;
            background-size: cover;
            height: 200vh;
        }

        .navbar {
            width: 100%;
            height: 75px;
            margin: auto;
            box-shadow: 5px 15px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .icon {
            color: chartreuse;
            font-size: 25px;
            font-family: Georgia;
            padding-left: 20px;
        }

        .menu ul {
            display: flex;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .menu ul li {
            margin-left: 62px;
            font-size: 14px;
            font-family: Arial;
        }

        .menu ul li a {
            text-decoration: none;
            color: #fff;
            font-family: Arial;
            font-weight: bold;
            transition: 0.4s ease-in-out;
        }

        .menu ul li a:hover {
            color: chartreuse;
        }

        .search {
            display: flex;
            align-items: center;
        }

        .srch {
            font-family: 'Times New Roman';
            width: 200px;
            height: 40px;
            background: transparent;
            border: 1px solid chartreuse;
            margin-top: 13px;
            color: black;
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
        }

        .btn {
            width: 100px;
            height: 40px;
            background: chartreuse;
            border: 2px solid chartreuse;
            margin-top: 13px;
            color: #fff;
            font-size: 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: .4s ease;
            margin-left: 10px;
        }

        .btn:focus,
        .srch:focus {
            outline: none;
        }

        .background {
            width: 100%;
            max-width: 430px;
            margin: 0 auto;
            padding: 60px 25px;
            background-color: rgba(255, 255, 255, 0.13);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
        }

        form {
            width: 100%;
        }

        form * {
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }

        form h3 {
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-size: 16px;
            font-weight: 500;
        }

        input,
        select {
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }

        ::placeholder {
            color: #e5e5e5;
        }

        button {
            margin-top: 20px;
            width: 100%;
            background-color: chartreuse;
            color: white;
            padding: 15px 0;
            font-size: 18px;
            font-weight: bolder;
            border-radius: 5px;
            cursor: pointer;
        }

        #passwordMessage {
            font-size: 12px;
        }
    </style>
</head>
<body onload="cap()">
<?php if ($user): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Oh No Sorry, </strong> User Already Exists!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="video-bg">
    <video autoplay loop muted>
        <source src="HOME.mp4" type="video/mp4">
    </video>
</div>

<div class="content">
    <div class="main">
        <div class="navbar">
            <div class="icon">
                <h2 class="logo">Future Phoenix</h2>
            </div>

            <div class="menu">
                <ul>
                    <li><a href="homepage 01.html">HOME</a></li>
                    <li><a href="login.php">USER LOGIN</a></li>
                    <li><a href="FAQ Page.html">HELP</a></li>
                    <li><a href="Contact us page.html">CONTACT US</a></li>
                </ul>
            </div>

            <div class="search">
                <input class="srch" type="search" placeholder="Type to Search">
                <a href="#"><button class="btn">Search</button></a>
            </div>
        </div>
<br><br>
        <div class="background">
            <form method="post" action="signup page.php" onsubmit="return validateForm()">
                <h3>Signup Here</h3>

                <label for="username">Name</label>
                <input type="text" placeholder="Name" id="username" name="username" required autocomplete="off">

                <label for="password">Password</label>
                <input type="password" placeholder="Password" id="password" name="password" required onkeyup="validatePassword()" autocomplete="off">
                <span id="passwordMessage" style="color:red;"></span>

                <label for="email">Email</label>
                <input type="email" placeholder="Email" id="email" name="email" required autocomplete="off">

                <label for="phone">Phone Number</label>
                <input type="tel" placeholder="Phone Number" id="phone" name="phone" required autocomplete="off">

                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>

                <label for="age">Age</label>
                <input type="number" placeholder="Age" id="age" name="age" required>

                <label for="city">City</label>
                <input type="text" placeholder="City" id="city" name="city" required>

                <label for="country">Country</label>
                <input type="text" placeholder="Country" id="country" name="country" required>

                <label>Enter Captcha:</label>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" readonly id="capt">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" id="textinput">
                    </div>
                </div>

                <button type="submit">Sign In</button>
            </form>
            <h6>Captcha not visible <img src="refresh.jpg" width="40px" onclick="cap()"></h6>
        </div>
    </div>
</div>
<script type="text/javascript">
    function cap(){
        var alpha = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V'
                     ,'W','X','Y','Z','1','2','3','4','5','6','7','8','9','0','a','b','c','d','e','f','g','h','i',
                     'j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', '!','@','#','$','%','^','&','*','+'];
        var a = alpha[Math.floor(Math.random()*71)];
        var b = alpha[Math.floor(Math.random()*71)];
        var c = alpha[Math.floor(Math.random()*71)];
        var d = alpha[Math.floor(Math.random()*71)];
        var e = alpha[Math.floor(Math.random()*71)];
        var f = alpha[Math.floor(Math.random()*71)];

        var final = a+b+c+d+e+f;
        document.getElementById("capt").value = final;
    }

    function validcap(){
        var stg1 = document.getElementById('capt').value;
        var stg2 = document.getElementById('textinput').value;
        if(stg1 == stg2){
            alert("Form is validated successfully");
            return true;
        } else {
            alert("Please enter a valid captcha");
            return false;
        }
    }
</script>
</body>
</html>
