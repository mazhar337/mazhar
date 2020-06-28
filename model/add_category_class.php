<?php

require_once 'db_connection.php';

class Add_Category extends DB_connection {

    public $categoryID;
    public $cat_title;
    public $cat_desc;
    public $cat_img;
    public $cat_seotitle;
    public $cat_seodesc;
    public $cat_slug;
    public $cat_status;
    public $created_date;
    public $objDBConnect;

    public function __construct() {
        //constructor
    }

    public function __set($name, $value) {
        $method = "set_" . $name;
        if (!method_exists($this, $method)) {
            throw new Exception("SET:Property $name does not exist");
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = "get_" . $name;
        if (!method_exists($this, $method)) {
            throw new Exception("GET:Property $name does not exist");
        }
        return $this->$method();
    }

    /*     * *************************************************************************************************** */

    private function set_categoryID($categoryID) {

        if (!is_numeric($categoryID) || $categoryID <= 0) {
            throw new Exception("Invalid/Missing category ID");
        }
        $this->categoryID = $categoryID;
    }

    private function get_categoryID() {
        return $this->categoryID;
    }

    /*     * ***************************************************************************************************** */

    private function set_cat_title($cat_title) {
        $reg = "/^[a-z]+$/i";
        if (!preg_match($reg, $cat_title)) {
            throw new Exception("Invalid/Missing category name");
        }
        $this->cat_title = $cat_title;
    }

    private function get_cat_title() {
        return $this->cat_title;
    }

    /*     * ***************************************************************************************************** */

    private function set_cat_desc($cat_desc) {
        $reg = "/^[a-z]+$/i";
        if (!preg_match($reg, $cat_desc)) {
            throw new Exception("Invalid/Missing category name");
        }
        $this->cat_desc = $cat_desc;
    }

    private function get_cat_desc() {
        return $this->cat_desc;
    }

    /*     * ****************************************************************************************** */

    private function set_cat_img($ci) {

        if ($ci['error'] == 4) {
            throw new Exception("FIle Missing");
        }

        if ($ci['size'] > 500) {
            throw new Exception("Maximum file size allowed is 500 K");
        }

        $image = getimagesize($ci['tmp_name']);

        if (!$image) {
            throw new Exception("Not a valid image");
        }

        if ($ci['type'] != "image/jpeg") {
            throw new Exception("only jpeg allowed");
        }


        if ($ci ['type'] != $image['mime']) {
            throw new Exception("Corrupt Image");
        }


        if (is_null($this->cat_title)) {
            throw new Exception("Failed to generate file name");
        }

        $file_name = "$this->cat_title.jpg";

        $this->cat_title = $file_name;
    }

    private function get_cat_img() {
        return $this->cat_img;
    }

    /*     * ***************************************************************************************************** */

    private function set_cat_seotitle($cat_seotitle) {
        $reg = "/^[a-z]+$/i";
        if (!preg_match($reg, $cat_seotitle)) {
            throw new Exception("Invalid/Missing category name");
        }
        $this->cat_seotitle = $cat_seotitle;
    }

    private function get_cat_seotitle() {
        return $this->cat_seotitle;
    }

    /*     * ***************************************************************************************************** */

    private function set_cat_seodesc($cat_seodesc) {
        $reg = "/^[a-z]+$/i";
        if (!preg_match($reg, $cat_seodesc)) {
            throw new Exception("Invalid/Missing category name");
        }
        $this->cat_seodesc = $cat_seodesc;
    }

    private function get_cat_seodesc() {
        return $this->cat_seodesc;
    }

    /*     * ***************************************************************************************************** */

    private function set_cat_slug($cat_slug) {
        $reg = "/^[a-z]+$/i";
        if (!preg_match($reg, $cat_slug)) {
            throw new Exception("Invalid/Missing category name");
        }
        $this->cat_slug = $cat_slug;
    }

    private function get_cat_slug() {
        return $this->cat_slug;
    }

    /*     * ***************************************************************************************************** */

    private function set_created_date($created_date) {
        $reg = "/^[a-z]+$/i";
        if (!preg_match($reg, $created_date)) {
            throw new Exception("Invalid/Missing category name");
        }
        $this->created_date = $created_date;
    }

    private function get_created_date() {
        return $this->created_date;
    }

    /*     * ***************************************************************************************************** */

    private function set_cat_status($cat_status) {

        if (empty($cat_status)) {
            throw new Exception("Invalid/Missing $cat_status");
        }
        $this->cat_status = $cat_status;
    }

    private function get_cat_status() {
        return $this->cat_status;
    }

    /*     * ***************************************************************************************************** */

    public function add_category() {

        $obj_db = $this->obj_db();

        $query_insert = "INSERT INTO `category` "
                . "(`categoryID`, `cat_title`, `cat_desc`,`cat_img`, `cat_seotitle`, `cat_seodesc`, `cat_slug`)"
                . "VALUES "
                . "(NULL, '$this->cat_title', '$this->cat_desc', '$this->cat_img', '$this->cat_seotitle', '$this->cat_seodesc', '$this->cat_slug')";


        $result = $obj_db->query($query_insert);

        if ($obj_db->errno) {
            throw new Exception("Insert New Category Error - $obj_db->error - $obj_db->errno");
        }
    }

    /*     * *************************************************************************************** */

    public function edit_category() {

        $obj_db = $this->obj_db();

        $query_update = "Update `category` set "
                . "cat_title = '$this->cat_title',"
                . "cat_desc = '$this->cat_desc'"
                . "cat_img = '$this->cat_img'"
                . "cat_seotitle = '$this->cat_seotitle'"
                . "cat_seodesc = '$this->cat_seodesc'"
                . "cat_slug = '$this->cat_slug'"
                . "cat_status = '$this->cat_status'"
                . "where categoryID = '$this->categoryID'";


        $result = $obj_db->query($query_update);

        if ($obj_db->errno) {
            throw new Exception("Update Category Error - $obj_db->error - $obj_db->errno");
        }
    }

    public function getcategory_byid($categoryID) {
        $obj_db = self::obj_db();
        $query_select = "select * "
                . "from category "
                . "where `categoryID` = $categoryID";
        $result = $obj_db->query($query_select);

        if ($obj_db->errno) {
            throw new Exception("Select category(s) Error - $obj_db->error - $obj_db->errno");
        }

        if ($result->num_rows == 0) {
            throw new Exception("category(s) not found");
        }


        $data = $result->fetch_object();

        $this->categoryID = $data->categoryID;
        $this->cat_title = $data->cat_title;
        $this->cat_desc = $data->cat_dsec;
        $this->cat_img = $data->cat_img;
        $this->cat_seotitle = $data->cat_seotitle;
        $this->cat_seodesc = $data->cat_seodesc;
        $this->cat_status = $data->cat_status;
//        $this->cat_title = $data->cat_title;
    }

}

?>