<?php

    require_once("Table.class.php");

    class Product implements Table {

        private $product_id;
        private $name;
        private $description;
        private $price;
        private $quantity;
        private $image;
        private $sale_price;
        private $on_sale;

        function getName(){ return $this->name; }
        function getDescription(){ return $this->description; }
        function getPrice(){ return $this->price; }
        function getQuantity(){ return $this->quantity; }
        function getImage(){ return $this->image; }
        function getSale_price(){ return $this->sale_price; }
        function getOn_sale(){ return $this->on_sale; }
        function getCartPrice() { return ($this->on_sale?$this->sale_price:$this->price); }

        function setProduct_id($product_id) { $this->product_id = $product_id; }
        function setName($name) { $this->name = $name; }
        function setDescription($description) { $this->description = $description; }
        function setPrice($price) { $this->price = $price; }
        function setQuantity($quantity) { $this->quantity = $quantity; }
        function setImage($image) { $this->image = $image; }
        function setSale_price($sale_price) { $this->sale_price = $sale_price; }
        function setOn_sale($on_sale) { $this->on_sale = $on_sale; }

        function getOnSale() { return "SELECT * FROM products WHERE on_sale = 1 AND quantity > 0 LIMIT 5"; }
        function getOnCatalog() { return "SELECT * FROM products WHERE on_sale = 0 AND quantity > 0 LIMIT :plimit OFFSET :poffset"; }
        function getUpdateQuantity() { return "UPDATE products SET quantity = :quantity WHERE product_id = :id"; }
        function getUpdateQuantityParams() { return array("quantity"=>$this->quantity, "id"=>$this->product_id); }
        function getUpdate() { return "UPDATE products SET name = :name, description = :description, price = :price, quantity = :quantity, image = :image, sale_price = :sale_price, on_sale = :on_sale WHERE product_id = :id"; }
        function getParamsUpdate() { return array("id"=>$this->product_id, "name"=>$this->name, "description"=>$this->description, "price"=>$this->price, "quantity"=>$this->quantity, "image"=>$this->image, "sale_price"=>$this->sale_price, "on_sale"=>$this->on_sale); }
        //function getSelectByUser() { return "SELECT * FROM products WHERE product_id IN (SELECT product_id FROM carts WHERE user_id = :user_id)"; }

        public function getId() { return $this->product_id; }
        public function getClassName() { return "Product"; }
        public function getInsert() { return "INSERT INTO products (name, description, price, quantity, image, sale_price, on_sale) VALUES (:name, :description, :price, :quantity, :image, :sale_price, :on_sale)"; }
        public function getParamsInsert() { return array("name"=>$this->name, "description"=>$this->description, "price"=>$this->price, "quantity"=>$this->quantity, "image"=>$this->image, "sale_price"=>$this->sale_price, "on_sale"=>$this->on_sale); }
        public function getSelectById() { return "SELECT * FROM products WHERE product_id = :id"; }
        public function getSelect() { return "SELECT * FROM products"; }

    }
