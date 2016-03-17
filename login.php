<?php
    require_once("LIB_project1.php");
    require_once("./DB/PDO.class.php");
    require_once("./DB/User.class.php");

    if(isset($_SESSION['user'])) {
        header("Location: index.php");
    }

    $db = DB::getInstance();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_name = sanitizeString($_POST['user_name']);
        $password = sanitizeString($_POST['password']);

        $user = new User();
        $user->setUser_name($user_name);
        $user = $db->getObjectByUserName($user);

        if (!$user) {
            $msg['code'] = "ERROR";
            $msg['mesg'] = "Wrong username or password";
        } else {
            if(confirm_password(array($password, $user->getSalt()), $user->getPassword())) {
                $_SESSION["user"] = array("user_id"=>$user->getId(), "user_name"=>$user->getUser_name());
                header("Location: index.php");
            } else {
                $msg['code'] = "ERROR";
                $msg['mesg'] = "Wrong username or password";
            }
        }
    }
    includeHeader();
?>

<div class="content-wrapper">
    <div class="content">
        <div class="login-div">
            <h2>Login</h2>
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

                    <button type="submit" class="pure-button pure-button-primary">Login</button>

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
