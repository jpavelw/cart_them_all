<?php
    require_once("LIB_project1.php");
    require_once("./DB/PDO.class.php");
    require_once("./DB/User.class.php");

    if(isset($_SESSION['user'])) {
        header("Location: index.php");
    }

    $db = DB::getInstance();
    includeHeader();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_name = sanitizeString($_POST['user_name']);
        $password = sanitizeString($_POST['password']);

        if(!strlen($user_name) >= 5 && !strlen($password) >= 5) {
            $msg['code'] = "ERROR";
            $msg['mesg'] = "Username and password must be at least 5 characters";
        } else {
            $user = new User();
            $user->setUser_name($user_name);
            $result = $db->getObjectByUserName($user);

            if (!$result) {
                $pass_info = hash_password($password);
                $user->setPassword($pass_info["password"]);
                $user->setSalt($pass_info["salt"]);
                $user->setIs_admin(0);
                $db->insert($user);
                $msg['code'] = "SUCCESS";
                $msg['mesg'] = "User added successfully";
            } else {
                $msg['code'] = "ERROR";
                $msg['mesg'] = "Username already exists in the database";
            }
        }
    }

?>

<div class="content-wrapper">
    <div class="content">
        <div class="login-div">
            <h2>Sign Up</h2>
            <form class="pure-form pure-form-aligned" action="" method="post">
                <fieldset>

                    <div class="pure-control-group">
                        <label for="name">Username</label>
                        <input id="name" type="text" placeholder="Username" name="user_name">
                    </div>

                    <div class="pure-control-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" placeholder="Password" name="password">
                    </div>

                    <button type="submit" class="pure-button pure-button-primary">Sign Up</button>

                </fieldset>
            </form>
            <?php
                if($msg['code'] === "SUCCESS") {
                    echo "<p class='msg-box msg-suc'>{$msg['mesg']}</p>";
                } else if($msg['code'] === "ERROR") {
                    echo "<p class='msg-box msg-err'>{$msg['mesg']}</p>";
                }
            ?>
        </div>
    </div>
</div>

<?php includeFooter(); ?>
