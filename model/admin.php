<?php

require_once 'db_connection.php';

class Admin extends DB_Connection {

    private $adminID, $username, $password, $created_date, $is_active, $login_status;

    function __construct() {
        
    }

    public function __set($name, $value) {
        $method = 'set_' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception("SET:Property $name Does not exist");
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get_' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception("GET:Property $name Dose not exist");
        }
        return $this->$method();
    }

//    ==================================================================


    private function set_adminID($adminID) {
        if (!is_numeric($adminID) || $adminID <= 0) {
            throw new Exception("invalid/missing adminID");
        }
        $this->adminID = $adminID;
    }

    private function get_adminID() {
        return $this->$adminID;
    }

    private function set_username($username) {
        $reg = "/^[a-z][a-z0-9]{5,19}$/i";
        if (!preg_match($reg, $username)) {
            throw new Exception("Invalid/Missing Admin username");
        }
        $this->username = $username;
    }

    private function get_username() {
        return $this->username;
    }

    private function set_password($password) {
        $reg = "/^[a-z][a-z0-9]{5,19}$/i";
        if (!preg_match($reg, $password)) {
            throw new Exception("Invalid/Missing admin password");
        }
        $this->password = $password;
    }

    private function get_password() {
        return $this->password;
    }

    private function get_login_status() {
        return $this->login_status;
    }

    public function login($remember = FALSE) {
        $obj_db = $this->obj_db();
        $query_select = "select adminID,username,password,is_active "
                . "from user "
                . "where username = '$this->username' "
                . "and password = '$this->password' ";


        $result = $obj_db->query($query_select);

        if ($obj_db->errno) {
            throw new Exception("Select Login admin Error - $obj_db->error - $obj_db->errno");
        }

        if ($result->num_rows == 0) {
            throw new Exception("Failed");
        }

        $data = $result->fetch_object();
        if (!$data->is_active) {
            throw new Exception("Your account is pending activation");
        }


/* @var $data type */
        $this->adminID = $data->adminID;
        $this->username = $data->username;
        $this->password = $data->password;
        $this->is_active = TRUE;
        $this->login_status = TRUE;

        $str_admin = serialize($this);
        $_SESSION['obj_admin'] = $str_admin;

        if ($remember) {
            $expire = time() + (60 * 60 * 24 * 15);
            setcookie("obj_admin", $str_admin, $expire, "/");
        }
//        echo($this->is_active);
//        die;
    }

    public function logout() {
        unset($_SESSION['obj_admin']);

        if (isset($_COOKIE['obj_admin'])) {
            setcookie("obj_admin", "", 1, "/");
        }
    }

}

?>