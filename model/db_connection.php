<?php

abstract class DB_Connection {

    protected static function obj_db() {
        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "baurami";

//        $host = "sql101.move.pk";
//        $user = "mov_19111641";
//        $password = "dz41n9ym";
//        $database = "mov_19111641_mart";


        $obj_db = new mysqli();
        $obj_db->connect($host, $user, $password);

        if ($obj_db->connect_errno) {
            throw new Exception("Database Connect Error - $obj_db->connect_error - $obj_db->connect_errno");
        }

        $obj_db->select_db($database);

        if ($obj_db->errno) {
            throw new Exception("Database Select Error - $obj_db->error - $obj_db->errno");
        }
        return $obj_db;
    }

}

?>