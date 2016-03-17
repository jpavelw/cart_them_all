<?php

    require_once("Table.class.php");

    class Cart implements Table {

        private $cart_id;
        private $user_id;
        private $product_id;
        private $quantity;

        function getUser_id(){ return $this->user_id; }
        function getProduct_id(){ return $this->product_id; }
        function getQuantity(){ return $this->quantity; }

        function setCart_id($cart_id) { $this->cart_id = $cart_id; }
        function setUser_id($user_id) { $this->user_id = $user_id; }
        function setProduct_id($product_id) { $this->product_id = $product_id; }
        function setQuantity($quantity) { $this->quantity = $quantity; }

        function getSelectByUser() { return "SELECT * FROM carts WHERE user_id = :user_id"; }
        function getDeleteByUser() { return "DELETE FROM carts WHERE user_id = :user_id"; }

        public function getId() { return $this->cart_id; }
        public function getClassName() { return "Cart"; }
        public function getInsert() { return "INSERT INTO carts (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)"; }
        public function getParamsInsert() { return array("user_id"=>$this->user_id, "product_id"=>$this->product_id, "quantity"=>$this->quantity); }
        public function getSelectById() { return "SELECT * FROM carts WHERE product_id = :id"; }
        public function getSelect() { return "SELECT * FROM carts"; }

    }
