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

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cart = new Cart();
        $cart->setUser_id($_SESSION['user']['user_id']);
        $cart->setProduct_id($_POST['item']);
        $cart->setQuantity(1);

        $result = $db->insert($cart);

        $product = new Product();
        $product->setProduct_id($_POST['item']);
        $product = $db->getObjectById($product);
        $product->setQuantity($product->getQuantity()-1);

        $db->updateProductQuantity($product);

        $msg['code'] = "SUCCESS";
        $msg['mesg'] = "The product was added to your cart";
    }


?>

        <div class="content-wrapper">
            <div class="content">

                <?php
                    if($msg['code'] === "SUCCESS") {
                        echo "<p class='msg-box msg-suc'>{$msg['mesg']}</p>";
                    }
                ?>

                <div class="on-sale-div">
                    <h1 class="content-head is-center on-sale-title">Items on Sale</h1>

                    <?php

                    $product = new Product();
                    $product->setOn_sale(1);
                    $products = $db->getProductsOnSale($product);

                    foreach ($products as $product) {
                        echo<<<EOF
                        <div class="product">
                            <h3 class="product-name">{$product->getName()}</h3>
                            <div class="product-img"><img width="168" src="{$product->getImage()}" /></div>
                            <div class="product-desc">
                                <table>
                                    <tr>
                                        <th>Description</th>
                                        <td>{$product->getDescription()}</td>
                                    </tr>
                                    <tr>
                                        <th>Original Price</th>
                                        <td>{$product->getPrice()}</td>
                                    </tr>
                                    <tr>
                                        <th>Sale Price</th>
                                        <td>{$product->getSale_price()}</td>
                                    </tr>
                                    <tr>
                                        <th>Only {$product->getQuantity()} left!</th>
                                        <td>
                                            <form method="post" action="">
                                                <input type="hidden" name="item" value="{$product->getId()}">
                                                <button class="pure-button button-warning" type="submit"><i class="fa fa-cart-plus"></i> Add to Cart!</button>
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <hr />
EOF;
                    } ?>
                </div>

                <div class="catalog-div">
                    <h1 class="content-head is-center catalog-title">Product Catalog</h1>

                    <?php

                    $product = new Product();
                    $product->setOn_sale(0);
                    if(isset($_GET['page']) && $_GET['page'] > 0) {
                        $page = $_GET['page'];
                    } else {
                        $page = 0;
                    }
                    $result = $db->getProductsOnCatalog($product, $page);
                    $products = $result['pdo'];
                    $pagination = $result['pagi'];
                    $limit = $pagination['limit'];
                    $left_rec = $pagination['left_rec'];

                    foreach ($products as $product) {
                        echo<<<EOF
                        <div class="product">
                            <h3 class="product-name">{$product->getName()}</h3>
                            <div class="product-img"><img width="168" src="{$product->getImage()}" /></div>
                            <div class="product-desc">
                                <table>
                                    <tr>
                                        <th>Description</th>
                                        <td>{$product->getDescription()}</td>
                                    </tr>
                                    <tr>
                                        <th>Price</th>
                                        <td>{$product->getPrice()}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Only {$product->getQuantity()} left!</th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                        <form method="post" action="">
                                            <input type="hidden" name="item" value="{$product->getId()}">
                                            <button class="pure-button button-warning" type="submit"><i class="fa fa-cart-plus"></i> Add to Cart!</button>
                                        </form>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <hr />
EOF;
                    }
                    echo "<p class='pagination'>";
                    if( $page == 0 && $left_rec > 0) {
                        $page = $page + 1;
                        echo "<a class='pure-button' href=\"$_PHP_SELF?page=$page\">Next 5 Records <i class='fa fa-chevron-right'></i></a>";
                    } else if ($page > 0 ) {
                        $last = $page - 1;
                        echo "<a class='pure-button' href=\"$_PHP_SELF?page=$last\"><i class='fa fa-chevron-left'></i> Last 5 Records</a>";

                        if($left_rec > 0) {
                            $page = $page + 1;
                            echo " <a class='pure-button' href=\"$_PHP_SELF?page=$page\">Next 5 Records <i class='fa fa-chevron-right'></i></a>";
                        }
                    }
                    echo "</p>";
                    /*if( $page > 0 ) {
                        $last = $page - 2;
                        echo "<a href = \"$_PHP_SELF?page=$last\">Last 5 Records</a> |";
                        echo "<a href = \"$_PHP_SELF?page=$page\">Next 5 Records</a>";
                    }   else if( $page == 0 ) {
                        $page = $page + 1;
                        echo "<a href = \"$_PHP_SELF?page=$page\">Next 5 Records</a>";
                    }   else if( $left_rec < $limit ) {
                        $last = $page - 2;
                        echo "<a href = \"$_PHP_SELF?page=$last\">Last 5 Records</a>";
                    }*/
                    ?>
                </div>
                <?php
                    /*echo "1";
                    require_once("./DB/PDO.class.php");
                    require_once("./DB/Product.class.php");

                    echo "2";
                    $db = DB::getInstance();
                    echo "3";
                    $product = new Product();
                    $product->setProduct_id(1);
                    echo "4";
                    $data = $db->getAllObjects($product);
                    echo "5";
                    //print_r($data);
                    echo "6";
                    $data = $db->getObjectById($product);
                    //echo $data->getDescription();
                    $product = new Product();
                    $product->setName("test");
                    $product->setDescription("test2");
                    $product->setPrice(123.89);
                    $product->setQuantity(9);
                    $product->setImage("url");
                    $product->setSale_price(45.90);
                    $product->setOn_sale(true);
                    //echo $db->insert($product);
                    echo "7";*/
                ?>
            </div>
        </div>
<?php includeFooter(); ?>
