<?php
    require_once("LIB_project1.php");
    require_once("./DB/PDO.class.php");
    require_once("./DB/Product.class.php");
    require_once("./DB/Cart.class.php");

    if(!isset($_SESSION['user'])) {
        header("Location: login.php");
    }

    $db = DB::getInstance();
    includeHeader();
    $products = array();
    $total = 0;

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        $cart = new Cart();
        $cart->setUser_id($_SESSION['user']['user_id']);
        $carts = $db->getCartByUser($cart);
        if(!$carts) {
            echo "hey";
            $msg['code'] = "WARNING";
            $msg['mesg'] = "You do not have any products in your cart";
        } else {
            foreach($carts as $cart) {
                $product = new Product();
                $product->setProduct_id($cart->getProduct_id());
                $product = $db->getObjectById($product);
                $products[] = $product;
                $total += $product->getCartPrice();
            }
        }
    } else if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cart = new Cart();
        $cart->setUser_id($_SESSION['user']['user_id']);
        $db->deleteCartByUser($cart);
        $msg['code'] = "WARNING";
        $msg['mesg'] = "You do not have any products in your cart";
    }
?>

        <div class="content-wrapper">
            <div class="content">

                <?php
                    if($msg['code'] === "SUCCESS") {
                        echo "<p class='msg-box msg-suc'>{$msg['mesg']}</p>";
                    } else if($msg['code'] === "WARNING") {
                        echo "<p class='msg-box msg-war'>{$msg['mesg']}</p>";
                    }

                    if($carts) {

                ?>

                <div class="cart-div">
                    <h1 class="content-head is-center cart-title">My Cart</h1>

                    <?php
                    foreach ($products as $product) {
                        echo<<<EOF
                        <div class="product">
                            <div class="product-desc">
                                <table>
                                    <tr>
                                        <th>Product Name</th>
                                        <td>{$product->getName()}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{$product->getDescription()}</td>
                                    </tr>
                                    <tr>
                                        <th>Price</th>
                                        <td>{$product->getCartPrice()}</td>
                                    </tr>
                                    <tr>
                                        <th>Quantity</th>
                                        <td>1</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <hr />
EOF;
                    } ?>
                    <p class="total-cart"><strong>Total:</strong> <?= $total ?></p>
                    <hr />
                    <form method="post" action="" class="center-align">
                        <button class="pure-button button-warning" type="submit"><i class="fa fa-cart-arrow-down"></i> Empty Cart</button>
                    </form>
                </div> <?php } ?>
            </div>
        </div>
<?php includeFooter(); ?>
