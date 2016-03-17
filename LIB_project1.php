<?php
    // Include top part of the website.
    function includeHeader() {

        require_once("./DB/PDO.class.php");
        require_once("./DB/User.class.php");
        $db = DB::getInstance();
        $user = new User();
        if (isset($_SESSION['user'])) {
            $user->setUser_name($_SESSION['user']['user_name']);
            $user = $db->getObjectByUserName($user);
            $admin = ($user->getIs_admin()?'<li class="pure-menu-item"><a href="admin.php" class="pure-menu-link"><i class="fa fa-cog"></i> Admin</a></li>':"");
            $user_name = "";
            $user_name = "Welcome ".$_SESSION['user']['user_name']."!";
        }

        if(!isset($_SESSION['user'])) {
            $logged = '<li class="pure-menu-item"><a href="sign_up.php" class="pure-menu-link"><i class="fa fa-user-plus"></i> Sign Up</a></li><li class="pure-menu-item"><a href="login.php" class="pure-menu-link"><i class="fa fa-sign-in"></i> Login</a></li>';
        } else {
            $logged = '<li class="pure-menu-item">'.$user_name.'</li>'.$admin.'<li class="pure-menu-item"><a href="index.php" class="pure-menu-link"><i class="fa fa-shopping-basket"></i> Shop</a></li><li class="pure-menu-item"><a href="cart.php" class="pure-menu-link"><i class="fa fa-shopping-cart"></i> My Cart</a></li><li class="pure-menu-item"><a href="logout.php" class="pure-menu-link"><i class="fa fa-sign-out"></i> Logout</a></li>';
        }

        echo<<<EOT

    <!DOCTYPE HTML>
    <html lang="en">
        <head>
            <title>Cart Them All!</title>
            <link rel="stylesheet" href="assets/css/pure-release-0.6.0/pure-min.css">
            <link rel="stylesheet" href="assets/font-awesome-4.5.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="assets/css/custom.css">
            <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>

        <body>
            <div class="header">
                <div class="home-menu pure-menu pure-menu-horizontal pure-menu-fixed">
                    <a class="pure-menu-heading" href="">Gotta Cart Them All!</a>

                    <ul class="pure-menu-list">

                        $logged

                    </ul>
                </div>
            </div>
EOT;
    }

    // Include bottom part of the website.
    function includeFooter() {
        echo<<<EOT

        </body>

        <footer>
            <div class="footer l-box is-center">
                Created by Jairo Veloz &copy; 2016 | Copyright All Rights Reserved
            </div>

            <script src="assets/js/jquery-1.11.3.min.js"></script>
            <script src="assets/js/angular.min.js"></script>
        </footer>
    </html>
EOT;
    }

    //sanitize form input
    function sanitizeString($string) {
        $string = stripslashes($string);
        $string = strip_tags($string);
        $string = htmlentities($string);
        $string = htmlspecialchars($string);
        $string = addslashes($string);

        return $string;
    }

    //hash password
    function hash_password($password) {
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $password = hash('sha256', $password . $salt);
        return array("password"=>$password, "salt"=>$salt);
    }

    //check if passwords match
    function confirm_password($password, $user_pass) {
        $hashed_pass = hash('sha256', $password[0] . $password[1]);
        if ($hashed_pass === $user_pass) {
            return true;
        }
        return false;
    }

    function alphaNumericSpace($value) {
    	$reg = "/^[A-Za-z0-9 ]+$/";
    	return preg_match($reg,$value);
    }

    function numbers($value) {
    	$reg = "/^[0-9]+$/";
    	return preg_match($reg,$value);
    }

    function decimal($value) {
    	$reg = "/^[0-9]*\.[0-9]+$/";
    	return preg_match($reg,$value);
    }

    function dollarAmount($value) {
    	$reg = "/^((\$\d*)|(\$\d*\.\d{2})|(\d*)|(\d*\.\d{2}))$/";
    	return preg_match($reg,$value);
    }

    session_start();
