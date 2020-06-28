<?php

require_once 'db_connection.php';

class category extends DB_Connection {

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
        
    }

    public static function get_category() {
        $obj_db = self::obj_db();
        $query_select = "select * from category";
//        $query_select = "select * "
//                . "from category";
        $result = $obj_db->query($query_select);

        if ($obj_db->errno) {
            throw new Exception("Select category(s) Error - $obj_db->error - $obj_db->errno");
        }

        if ($result->num_rows == 0) {
            throw new Exception("category(s) not found");
        }

        $category = array();
        while ($data = $result->fetch_object()) {

            $temp = new category();
            $temp->categoryID = $data->categoryID;
            $temp->cat_status = $data->cat_status;
            $temp->cat_title = $data->cat_title;
            $temp->cat_desc = $data->cat_desc;
            $temp->cat_img = $data->cat_img;
            $temp->cat_seotitle = $data->cat_seotitle;
            $temp->cat_seodesc = $data->cat_seodesc;
            $temp->cat_slug = $data->cat_slug;
            $category[] = $temp;
        }

        return $category;
    }

    public static function search_category($keyword) {

        if (empty($keyword)) {
            throw new Exception("Missing Keyword");
        }
        $obj_db = self::obj_db();
        $query = "select * from `category`"
                . "where `category_name` like '%" . $keyword . "%' ";


        $result_select = @$obj_db->query($query);

        if ($obj_db->errno) {
            throw new Exception("Select  Search Categroy Error - $obj_db->error - $obj_db->errno");
        }

        if ($result_select->num_rows == 0) {
            throw new Exception("No result For '$keyword' In Category");
        }

        $category = array();
        while ($data = $result_select->fetch_object()) {
            $temp = new self();
            $temp->category_ID = $data->category_ID;
            $temp->cat_title = $data->cat_title;
            $category[] = $temp;
        }
        return $category;
    }

    public function delete_category() {
        $obj_db = $this->obj_db();

        $query_delete = "delete from category "
                . "where category_ID = '$this->category_ID'";


        $result = $obj_db->query($query_delete);

        if ($obj_db->errno) {
            throw new Exception("Delete category Error - $obj_db->error - $obj_db->errno");
        }

        if ($obj_db->affected_rows == 0) {
            throw new Exception("Nothing deleted");
        }
    }

}

?>