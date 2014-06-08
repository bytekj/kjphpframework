<?php

/**
 * Description of DataHandler
 *
 * @author kiran
 */
class DataHandler {

//put your code here
    var $db_link;

    public function __construct() {
        $this->db_link = NULL;
    }

    private function getUserName() {
        return DB_USERNAME;
    }

    private function getPassword() {
        return DB_PASS;
    }

    private function getDatabase() {
        return DB;
    }
    private function getDBURL(){
        return DB_URL;
    }

    public function connect() {
        //$link = mysqli_connect('localhost', DataHandler::getUserName(), DataHandler::getPassword(), DataHandler::getDatabase());
        $link = new mysqli(DataHandler::getDBURL(),DataHandler::getUserName(), DataHandler::getPassword(), DataHandler::getDatabase());
        if ($link->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        else{
            /*
            if(DEBUG == 1){
                echo "<pre>";
                print_r($link->host_info);
                echo "</pre>";

            }
            */
            $this->db_link = $link;
        }
    }

    public function Disconnect() {
        if($this->db_link->close())
            $this->db_link == NULL;
    }

    public function GetQuery($sql) {
        try {
            $this->connect();
            $result_set = "";
            $cnt = 0;
            $result = $this->db_link->query($sql);
            while($row = $result->fetch_assoc()){
                $result_set[$cnt] = $row;
                $cnt++;
            }
            $this->Disconnect();
            return $result_set;
        } catch (Exception $e) {
            echo "<pre>";
            print_r($e);
            echo "</pre>";
        }
    }

    public function PutQuery($sql) {
        $this->connect();
        $ret = '';
        try {

            $res = $this->db_link->query($sql);
            $error = $this->db_link->error;

            $ret['result'] = $res;
            $ret['error'] = $error;

            $this->Disconnect();
        } catch (Exception $e) {

        }
        return $ret;
    }

    public function NoConnectPutQuery($sql) {
        $ret = '';
        try {
            $res = $this->db_link->query($sql);
            $error = $this->db_link->error;

            $ret['result'] = $res;
            $ret['error'] = $error;
        } catch (Exception $e) {

        }
        return $ret;
    }

    public function NoConnectGetQuery($sql) {
        $res = '';
        try {
            $res = $this->db_link->query($sql);
        } catch (Exception $e) {

        }
        return $res;
    }

    public function LastInsertID(){
        return $this->db_link->insert_id;
    }
    public function Proc($proc) {
        $res = mysqli_query($proc);
        $error = mysqli_errno();
        if ($error == 0)
            return $res;
        else
            return -1;
    }

    public function GetProcOutput($sql) {
        $res = mysqli_query($sql);
        $error = mysqli_errno();
        $cnt = 0;
//echo $sql;
        if ($error == 0) {
            $result_set = "";
//echo "printing row";
            while ($row = mysqli_fetch_assoc($res)) {
                $result_set[$cnt] = $row;
                $cnt++;
            }
            return $result_set;
        } else {
            return -1;
        }
    }

}

?>
