<!--<link href="<?php // echo (BASE_URL);?>model/db_connection.php"-->
<?php
//echo (BASE_URL);
require_once 'db_connection.php';


class Admin extends DB_Connection {

    private $adminID;
    private $username;
    private $password;
    private $created_date;
    private $login_status;

    function __construct() {

//          $this->interests = array();
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

    /*     * ***************************************************************** */

    private function set_adminID($adminID) {
        if (!is_numeric($adminID) || $adminID <= 0) {
            throw new Exception("Invalid/Missing adminID");
        }
        $this->adminID = $adminID;
    }

    private function get_adminID() {
        return $this->$adminID;
    }

    /*     * ************************************************************* */

    private function set_username($username) {
        $reg = "/^[a-z][a-z0-9]{5,19}$/i";
        if (!preg_match($reg, $username)) {
            throw new Exception("Invalid/Missing admin username");
        }
        $this->username = $username;
    }

    private function get_username() {
        return $this->username;
    }

    /*     * ************************************************************************ */

    private function set_password($password) {
        $reg = "/^[a-z][a-z0-9]{5,15}+$/i";
        if (!preg_match($reg, $password)) {
            throw new Exception("Invalid/Missing password");
        }
        $this->password = $password;
    }

    private function get_password() {
        return $this->password;
    }

    /*     * ************************************************************************** */

    private function get_created_date() {
        return $this->created_date;
    }

    /*     * **************************************************************************** */

    private function get_login_status() {
        return $this->login_status;
    }

    public function login($remember = FALSE) {
        $obj_db = $this->obj_db();
        $query_select = "select adminID,username,password,admin_status "
                . "from admin "
                . "where username = '$this->username' "
                . "and password = '$this->password' ";


        $result = $obj_db->query($query_select);

        if ($obj_db->errno) {
            throw new Exception("Select Login admin Error - $obj_db->error - $obj_db->errno");
        }

        if ($result->num_rows == 0) {
            throw new Exception("Failed");
        }

//i think it not use for user
        $data = $result->fetch_object();
        if (!$data->admin_status) {
            throw new Exception("Your account is pending activation");
        }
        
        
        $this->adminID = $data->adminID;
        $this->username = $data->username;
        $this->password = $data->password;
        $this->login_status = TRUE;

        $str_admin = serialize($this);
        $_SESSION['obj_admin'] = $str_admin;

        if ($remember) {
            $expire = time() + (60 * 60 * 24 * 15);
            setcookie("obj_admin", $str_admin, $expire, "/");
        }
//        echo($this->admin_status);
//        die;
    }

    public function logout() {
        unset($_SESSION['obj_admin']);

        if (isset($_COOKIE['obj_admin'])) {
            setcookie("obj_admin", "", 1, "/");
        }
    }

    /*     * **************************************************************************** */

    private function activate($act_code) {
        $reg = "/^[a-z0-9]{32}$/";
        if (!preg_match($reg, $act_code)) {
            throw new Exception("Invalid/Missing Act Code");
        }
        $obj_db = $this->obj_db();

        //$query_select = "select * from users";
        $query_select = "select adminID, "
                . "is_active, created_date "
                . "from admin "
                . "where adminID = '$this->adminID' "
                . "and reset_code = '$act_code'";


        $result = $obj_db->query($query_select);

        if ($obj_db->errno) {
            throw new Exception("Select Activate User Error - $obj_db->error - $obj_db->errno");
        }

        if ($result->num_rows == 0) {
            throw new Exception("Invalid Activation Data");
        }

        $data = $result->fetch_object();

        if ($data->is_active) {
            throw new Exception("Your account is already active");
        }
        //$sql_ts = date("Y-m-d H:i:s");
        $signup_date = strtotime($data->signup_date);
        $expiry_time = $signup_date + (60 * 60 * 24 * 3);
        $now = time();
        if ($now > $expiry_time) {
            $this->delete_admin();
            throw new Exception("Your activation link has expired");
        }
        $query_update = "update admin set "
                . "is_active = '1' "
                . "where adminID = '$this->adminID'";
        //echo($query_update);
        //die;
        $result = $obj_db->query($query_update);
        if ($obj_db->errno) {
            throw new Exception("Update Activate Admin Error - $obj_db->error - $obj_db->errno");
        }
    }

    public static function pagination($item_per_page = 5) {
        $obj_db = self::obj_db();
        $query = "select count(*) 'count' from `users`"; //alias
        $result = $obj_db->query($query);
        if ($result->num_rows == 0) {
            throw new Exception("Product(s) not found");
        }
        $data = $result->fetch_object();
        $total_items = $data->count;
        $page_count = ceil($total_items / $item_per_page);
        $page_nums = array();
        for ($i = 1, $j = 0; $i <= $page_count; $i++, $j+=$item_per_page) {
            $page_nums[$i] = $j;
        }
        return $page_nums;
    }

}

?>
