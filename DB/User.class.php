<?php

    require_once("Table.class.php");

    class User implements Table {

        private $user_id;
        private $user_name;
        private $password;
        private $salt;
        //private $email;
        private $is_admin;

        function getUser_name(){ return $this->user_name; }
        function getPassword(){ return $this->password; }
        function getSalt(){ return $this->salt; }
        //function getEmail(){ return $this->email; }
        function getIs_admin(){ return $this->is_admin; }

        function setUser_id($user_id) { $this->user_id = $user_id; }
        function setUser_name($user_name) { $this->user_name = $user_name; }
        function setPassword($password) { $this->password = $password; }
        function setSalt($salt) { $this->salt = $salt; }
        //function setEmail($email) { $this->email = $email; }
        function setIs_admin($is_admin) { $this->is_admin = $is_admin; }
        public function getUserByUserName() { return "SELECT * FROM users WHERE user_name = '{$this->user_name}'"; }

        public function getId() { return $this->user_id; }
        public function getClassName() { return "User"; }
        public function getInsert() { return "INSERT INTO users (user_name, password, salt, is_admin) VALUES (:user_name, :password, :salt, :is_admin)"; }
        public function getParamsInsert() { return array("user_name"=>$this->user_name, "password"=>$this->password, "salt"=>$this->salt, "is_admin"=>$this->is_admin); }
        public function getSelectById() { return "SELECT * FROM users WHERE user_id = :id"; }
        public function getSelect() { return "SELECT * FROM users"; }

    }
