<?php
    interface Table {

        public function getId();
        public function getClassName();
        public function getInsert();
        public function getParamsInsert();
        public function getSelectById();
        public function getSelect();

    }
