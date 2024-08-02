<?php
session_start();

$login = 0;
$invalid = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $con->prepare("SELECT password FROM registration WHERE username =?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($stored_password);
            $stmt->fetch();

            if ($password == $stored_password) {
                $_SESSION['username'] = $username;
                $login = 1;
                header('Location: homepage 02.html');
                exit();
            } else {
                $invalid = 1;
            }
        } else {
            $invalid = 1;
        }
    } catch (Exception $e) {
        echo 'Error: '. $e->getMessage();
    }

    $stmt->close();
    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
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
        * {
            margin: 0;
            padding: 0;
        }
        .main {
            width: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.5) 50%, rgba(0, 0, 0, 0.5) 50%);
            background-position: center;
            background-size: cover;
            height: 109vh;
        }
        .navbar {
            width: 1200px;
            height: 75px;
            margin: auto;
            box-shadow: 5px 15px 15px;
        }
        .icon {
            width: 200px;
            float: left;
            height: 70px;
            color: chartreuse;
            font-size: 25px;
            font-family: Georgia;
            padding-left: 0px;
            padding-top: 10px;
        }
        .menu {
            width: 400px;
            float: left;
            height: 70px;
        }
        ul {
            float: left;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        ul li {
            list-style: none;
            margin-left: 62px;
            margin-top: 27px;
            font-size: 14px;
            font-family: Arial;
        }
        ul li a {
            text-decoration: none;
            color: #fff;
            font-family: Arial;
            font-weight: bold;
            transition: 0.4s ease-in-out;
        }
        ul li a:hover {
            color: chartreuse;
        }
        .search {
            width: 330px;
            float: left;
            margin-left: 270px;
            padding-top: 10px;
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
            float: left;
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
        }
        .btn:focus {
            outline: none;
        }
        .srch:focus {
            outline: none;
        }
        .btnn {
            width: 240px;
            height: 40px;
            background: chartreuse;
            border: none;
            margin-top: 30px;
            font-size: 18px;
            border-radius: 10px;
            cursor: pointer;
            color: #fff;
            transition: .4s ease;
        }
        .btnn:hover {
            background-color: #fff;
            color: chartreuse;
        }
        .btnn a {
            text-decoration: none;
            color: black;
            font-weight: bold;
        }
        *:before, *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #080710;
        }
        .background {
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 60%;
        }
        form {
            height: 520px;
            width: 400px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 60px 25px;
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
        }
        label {
            display: block;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 500;
        }
        input {
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
            margin-top: 50px;
            width: 100%;
            background-color: chartreuse;
            color: white;
            padding: 15px 0;
            font-size: 18px;
            font-weight: bolder;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php 
if($invalid):?>
<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
    <strong>Oh No Sorry, </strong> User name and Password do not match. If not a user then Sign Up! 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span></button> </div>
    <?php endif;  ?>

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
                    <input class="srch" type="search" name="" placeholder="Type to Text">
                    <a href="#"><button class="btn">Search</button></a>
                </div>

            </div>
            
              <div class="background">
                  <form method="post" action="login.php">
                  <h3>Login Here</h3>
          
                  <label for="username">Name</label>
                  <input type="text" placeholder="Name" id="username" name="username" required><br>
          
                  <label for="password">Password</label>
                  <input type="password" placeholder="Password" id="password" name="password" required><br>
                  
                  <br>
                  <button>Login</button><br><br>
              </form>

                    
                    
           
        </div>
          </div>
          </div>
    </body>
</html>
