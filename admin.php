<?php

    require_once("LIB_project1.php");
    require_once("./DB/PDO.class.php");
    require_once("./DB/Product.class.php");

    $db = DB::getInstance();

    if(!isset($_SESSION['user'])) {
        header("Location: login.php");
    } else {
        require_once("./DB/User.class.php");
        $user = new User();
        $user->setUser_name($_SESSION['user']['user_name']);
        $user = $db->getObjectByUserName($user);
        if(!$user->getIs_admin()) {
            header("Location: index.php");
        }
    }

    includeHeader();

    try {
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
        } else if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['add-product'])) {
                $product = new Product();
                if(!alphaNumericSpace($_POST['name']) || !alphaNumericSpace($_POST['description']) || !dollarAmount($_POST['price']) || $_POST['price'] < 0 || !numbers($_POST['quantity']) || $_POST['quantity'] < 0 || !dollarAmount($_POST['sale_price']) || $_POST['sale_price'] < 0) {
                    $msg['code'] = "ERROR";
                    $msg['mesg'] = "The information provided is invalid. Please verify";
                    throw new Exception('Failed');
                }

                $product->setName(sanitizeString($_POST['name']));
                $product->setDescription(sanitizeString($_POST['description']));
                $product->setPrice(sanitizeString($_POST['price']));
                $product->setQuantity(sanitizeString($_POST['quantity']));
                $product->setSale_price(sanitizeString($_POST['sale_price']));

                $on_sale = ($_POST['on_sale']==="YES"?1:0);
                $product->setOn_sale($on_sale);

                if($_POST['on_sale']==="NO") {
                    $product->setSale_price(0);
                }

                if (!empty($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $filename = basename($_FILES['image']['name']);
                    $ext = substr($filename, strrpos($filename, '.') + 1);
                    if($_FILES['image']['size'] < 5000000 && ($_FILES['image']['type'] == "image/jpeg" || $_FILES['image']['type'] == "image/pjpeg" || $_FILES['image']['type'] == "image/png")) {
                        $image_name = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
                        $newname = "assets/img/$image_name.$ext";
                        if(move_uploaded_file($_FILES['image']['tmp_name'], $newname)) {
                            chmod($newname, 0644);
                            $product->setImage($newname);
                        }
                    } else {
                        $msg['code'] = "ERROR";
                        $msg['mesg'] = "Wrong image size or type";
                    }
                } else {
                    $msg['code'] = "ERROR";
                    $msg['mesg'] = "Image is required";
                }

                if(!numbers($db->insert($product))) {
                    $msg['code'] = "ERROR";
                    $msg['mesg'] = "The product could not be saved";
                }
            } else if(isset($_POST['search-product'])) {
                $update_product = new Product();
                $update_product->setProduct_id($_POST['product']);
                $update_product = $db->getObjectById($update_product);
            } else if (isset($_POST['update-product'])) {

                if(!alphaNumericSpace($_POST['name']) || !alphaNumericSpace($_POST['description']) || !dollarAmount($_POST['price']) || $_POST['price'] < 0 || !numbers($_POST['quantity']) || $_POST['quantity'] < 0 || !dollarAmount($_POST['sale_price']) || $_POST['sale_price'] < 0) {
                    $msg['code'] = "ERROR";
                    $msg['mesg'] = "The information provided is invalid. Please verify";
                    throw new Exception('Failed');
                }

                $product = new Product();
                $product->setProduct_id(sanitizeString($_POST['product_id']));
                $product->setName(sanitizeString($_POST['name']));
                $product->setDescription(sanitizeString($_POST['description']));
                $product->setPrice(sanitizeString($_POST['price']));
                $product->setQuantity(sanitizeString($_POST['quantity']));
                $product->setSale_price(sanitizeString($_POST['sale_price']));

                $on_sale = ($_POST['on_sale']==="YES"?1:0);
                $product->setOn_sale($on_sale);

                if($_POST['on_sale']==="NO") {
                    $product->setSale_price(0);
                }

                if (!empty($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $filename = basename($_FILES['image']['name']);
                    $ext = substr($filename, strrpos($filename, '.') + 1);
                    if($_FILES['image']['size'] < 5000000 && ($_FILES['image']['type'] == "image/jpeg" || $_FILES['image']['type'] == "image/pjpeg" || $_FILES['image']['type'] == "image/png")) {
                        $image_name = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
                        $newname = "assets/img/$image_name.$ext";
                        if(move_uploaded_file($_FILES['image']['tmp_name'], $newname)) {
                            chmod($newname, 0644);
                            $product->setImage($newname);
                        }
                    } else {
                        $msg['code'] = "ERROR";
                        $msg['mesg'] = "Wrong image size or type";
                    }
                } else {
                    $product->setImage(sanitizeString($_POST['old_image']));
                }

                if($result = $db->update($product) != 1) {
                    $msg['code'] = "ERROR";
                    $msg['mesg'] = "The product could not be updated";
                }
            }
        }
    } catch (Exception $e) {  }
?>

        <div class="content-wrapper">
            <div class="content">

                <?php
                    if($msg['code'] === "SUCCESS") {
                        echo "<p class='msg-box msg-suc'>{$msg['mesg']}</p>";
                    } else if($msg['code'] === "ERROR") {
                        echo "<p class='msg-box msg-err'>{$msg['mesg']}</p>";
                    }
                ?>

                <div class="update add-admin-div">
                    <h1 class="content-head is-center cart-title">Add Product</h1>

                    <form class="pure-form pure-form-aligned" action="" method="post" enctype="multipart/form-data">
                        <table class="cell-padding-10">
                            <tr>
                                <td><label for="name">Name</label></td>
                                <td><input id="name" type="text" placeholder="Name" name="name"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><label for="description">Description</label></td>
                                <td><textarea placeholder="Description" id="description" name="description" class="not-resize" cols="50" rows="3"></textarea></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><label for="price">Price</label></td>
                                <td><input id="price" type="text" placeholder="Price" name="price"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><label for="quantity">Quantity</label></td>
                                <td><input id="quantity" type="text" placeholder="Quantity" name="quantity"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><label for="sale_price">Sale Price</label></td>
                                <td><input id="sale_price" type="text" placeholder="Sale Price" name="sale_price"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>On Sale</td>
                                <td>
                                    <label for="yes" class="pure-radio left-radio">
                                        <input id="yes" type="radio" name="on_sale" value="YES"> Yes
                                    </label>
                                    <label for="no" class="pure-radio left-radio">
                                        <input id="no" type="radio" name="on_sale" value="NO"> No
                                    </label>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><label for="image">Image</label></td>
                                <td><input id="image" type="file" name="image"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <p class='add-inputs'>
                                        <button class='pure-button' type="reset"><i class="fa fa-minus-square"></i> Reset</button>
                                        <button class='pure-button' type="submit" name="add-product"><i class="fa fa-plus-square"></i> Add</button>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <div class="update update-admin-div">
                    <h1 class="content-head is-center cart-title">Update Product</h1>
                    <form class="pure-form pure-form-aligned" action="" method="post">
                        <table class="cell-padding-10">
                            <tr>
                                <td><label for="product">Select Product to Edit</label></td>
                                <td>
                                    <select id="product" name="product" class="full-width">
                                        <?php
                                            $product = new Product();
                                            $products = $db->getAllObjects($product);
                                            foreach ($products as $product) {
                                                echo "<option value='{$product->getId()}'>{$product->getName()} | {$product->getDescription()}</option>";
                                            }
                                        ?>
                                    </select>
                                </td>
                                <td><button class='pure-button' type="submit" name="search-product"><i class="fa fa-search"></i> Search</button></td>
                            </tr>
                        </table>
                    </form>
                    <?php if($update_product) { ?>
                    <form class="pure-form pure-form-aligned" action="" method="post">
                        <input type="hidden" name="product_id" value="<?= $update_product->getId() ?>">
                        <input type="hidden" name="old_image" value="<?= $update_product->getImage() ?>">
                        <table class="cell-padding-10">
                            <tr>
                                <td><label for="name">Name</label></td>
                                <td><input id="name" type="text" name="name" value="<?= $update_product->getName() ?>"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><label for="description">Description</label></td>
                                <td><textarea id="description" name="description" class="not-resize" cols="50" rows="3"><?= $update_product->getDescription() ?></textarea></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><label for="price">Price</label></td>
                                <td><input id="price" type="text" name="price" value="<?= $update_product->getPrice() ?>"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><label for="quantity">Quantity</label></td>
                                <td><input id="quantity" type="text" name="quantity" value="<?= $update_product->getQuantity() ?>"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><label for="sale_price">Sale Price</label></td>
                                <td><input id="sale_price" type="text" name="sale_price" value="<?= $update_product->getSale_price() ?>"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>On Sale</td>
                                <td>
                                    <label for="yes" class="pure-radio left-radio">
                                        <input id="yes" type="radio" name="on_sale" value="YES" <?php if($update_product->getOn_sale()) { echo "checked"; } ?> > Yes
                                    </label>
                                    <label for="no" class="pure-radio left-radio">
                                        <input id="no" type="radio" name="on_sale" value="NO" <?php if(!$update_product->getOn_sale()) { echo "checked"; } ?> > No
                                    </label>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><label for="image">Image</label></td>
                                <td><input id="image" type="file" name="image"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <p class='add-inputs'>
                                        <button class='pure-button' type="submit" name="update-product"><i class="fa fa-pencil-square-o"></i> Update</button>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
<?php includeFooter(); ?>
