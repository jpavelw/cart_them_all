<?php
    class DB {

        private $dbh;
        private static $instance = null;

        public static function getInstance() {
            if (null === self::$instance) {
                self::$instance = new DB();
            }

            return self::$instance;
        }

        private function __construct() {
            require_once("../../../dbInfo.php");
            try {
                $this->dbh = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
                // change error reporting
                $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PODException $e) {
                die("Bad database connection");
            }
        } // constructor

        private function __clone() { }

        private function __wakeup() { }

        function insert($table) {
            try {
                require_once("{$table->getClassName()}.class.php");
                $data = Array();
                $stmt = $this->dbh->prepare($table->getInsert());
                $stmt->execute($table->getParamsInsert());
                return $this->dbh->lastInsertId();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        function getAllObjects($table) {
            try {
                require_once("{$table->getClassName()}.class.php");
                $data = Array();
                $stmt = $this->dbh->prepare($table->getSelect());
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_CLASS, $table->getClassName());
                while($object = $stmt->fetch()) {
                    $data[] = $object;
                }
                return $data;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        function getObjectById($table) {
            try {
                require_once("{$table->getClassName()}.class.php");
                $stmt = $this->dbh->prepare($table->getSelectById());
                $stmt->execute(array("id"=>$table->getId()));
                $stmt->setFetchMode(PDO::FETCH_CLASS, $table->getClassName());
                $item = $stmt->fetch();
                return $item;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        function getObjectByUserName($table) {
            try {
                require_once("{$table->getClassName()}.class.php");
                $stmt = $this->dbh->prepare($table->getUserByUserName());
                $stmt->execute();
                if ($stmt->rowCount() === 0) {
                    return false;
                } else {
                    $stmt->setFetchMode(PDO::FETCH_CLASS, $table->getClassName());
                    $person = $stmt->fetch();
                    return $person;
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        function getProductsOnSale($table) {
            try {
                require_once("{$table->getClassName()}.class.php");
                $data = Array();
                $stmt = $this->dbh->prepare($table->getOnSale());
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_CLASS, $table->getClassName());
                while($object = $stmt->fetch()) {
                    $data[] = $object;
                }
                return $data;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        function getProductsOnCatalog($table, $page = 0) {
            try {
                $limit = 5;
                require_once("{$table->getClassName()}.class.php");

                $stmt = $this->dbh->prepare("SELECT COUNT(product_id) FROM products WHERE on_sale = 0 AND quantity > 0");
                $stmt->execute();
                $count = $stmt->fetch();
                $count = $count[0];

                if($page > 0) {
                    $offset = $limit * $page;
                } else {
                    $page = 0;
                    $offset = 0;
                }

                $left_rec = $count - ($page * $limit) - $limit;

                $data = Array();
                $stmt = $this->dbh->prepare($table->getOnCatalog());
                $stmt->bindParam(":plimit", $limit, PDO::PARAM_INT);
                $stmt->bindParam(":poffset", $offset, PDO::PARAM_INT);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_CLASS, $table->getClassName());
                while($object = $stmt->fetch()) {
                    $data['pdo'][] = $object;
                }
                $data['pagi']['limit'] = $limit;
                $data['pagi']['left_rec'] = $left_rec;
                return $data;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        function updateProductQuantity($table) {
            try {
                require_once("{$table->getClassName()}.class.php");
                $stmt = $this->dbh->prepare($table->getUpdateQuantity());
                $stmt->execute($table->getUpdateQuantityParams());
                return true;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        function getCartByUser($table) {
            try {
                require_once("{$table->getClassName()}.class.php");
                $stmt = $this->dbh->prepare($table->getSelectByUser());
                $stmt->execute(array("user_id"=>$table->getUser_id()));
                if ($stmt->rowCount() === 0) {
                    return false;
                } else {
                    $data = Array();
                    $stmt->setFetchMode(PDO::FETCH_CLASS, $table->getClassName());
                    while($object = $stmt->fetch()) {
                        $data[] = $object;
                    }
                    return $data;
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        function deleteCartByUser($table) {
            try {
                require_once("{$table->getClassName()}.class.php");
                $stmt = $this->dbh->prepare($table->getDeleteByUser());
                $stmt->execute(array("user_id"=>$table->getUser_id()));
                return true;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        function update($table) {
            try {
                require_once("{$table->getClassName()}.class.php");
                $stmt = $this->dbh->prepare($table->getUpdate());
                $stmt->execute($table->getParamsUpdate());
                return $stmt->rowCount();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        /*function getProductsByUser($table, $user_id) {
            try {
                require_once("{$table->getClassName()}.class.php");
                $stmt = $this->dbh->prepare($table->getSelectByUser());
                $stmt->execute(array("user_id"=>$user_id));
                if ($stmt->rowCount() === 0) {
                    return false;
                } else {
                    $data = Array();
                    $stmt->setFetchMode(PDO::FETCH_CLASS, $table->getClassName());
                    while($object = $stmt->fetch()) {
                        $data[] = $object;
                    }
                    return $data;
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }*/
    }
