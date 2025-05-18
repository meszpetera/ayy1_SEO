<?php

/**
 * DB_mysql
 *
 * @package MySQL Database Handler
 * @author Serfőző Dávid
 * @copyright 2007
 * @version 1.0
 * @access public
 */
class mysql {

    public $debug = false;
    public $connected = false;
    private $connection;
    private $config;

    /**
     * Constructor for DB_mysql5. Set the access variables of the class and
     * attempt to connect to the defined db.
     *
     * @param string $host defines the host of mysql server
     * @param string $passwd defines the password for access to the database server
     * @param string $user defines the username with which you'd like to connect to the db
     * @param string $database defines the which you want to use
     */
    public function __construct($host = 'localhost', $passwd = '', $user = '', $database = '') {

        $this->config['db_host'] = $host;
        $this->config['db_pass'] = $passwd;
        $this->config['db_user'] = $user;
        $this->config['db_database'] = $database;

        $this->connect();
    }

    /**
     * A simple descturctor for class DB_mysql.
     * It simply calls another tag-fucntion called 'disconnect'.
     */
    public function __destruct() {
        $this->disconnect();
    }

    /**
     * This prepares an SQL statement for execution.
     *
     * @param string $query the SQL statement with '?' markers to be
     * replaced with the binded variables.
     *
     * @return DB_mysql5_stmnt the further operations with the query will
     * be done through the returned class.
     */
    public function prepare($query) {
        if ($this->connected) {
            return new mysql_stmnt($this->connection, $query);
        } else {
            if ($this->debug) {
                trigger_error('No connection!', E_USER_ERROR);
            }
        }
    }

    /**
     * This function executes an SQL statement.
     *
     * @param string $query the SQL statement to be executed.
     *
     * @return DB_mysql_stmnt the further operations with the query will
     * be done through the returned class.
     */
    public function execute($query) {
        Stat::increment('mysql.execute');
        if ($this->connected) {
            $db = new mysql_stmnt($this->connection, $query);
            $db->execute();
            if ($this->connection)
                return $db;
        }
        else {
            if ($this->debug) {
                trigger_error('No connection!', E_USER_ERROR);
            }
        }
    }

    /**
     * Tries to connect to the mysql server and the desired database.
     *
     * @return boolean if debug mode is off it returns false if connectiing failed and tur if it was succesfull, if      * debug mode is online the function throws MysqlExcetions if error happen.
     */
    private function connect() {
        $this->connection = mysql_connect($this->config['db_host'], $this->config['db_user'], $this->config['db_pass']);
        if (!$this->connection) {
            if ($this->debug) {
                trigger_error('Failed to connect to the mysql server!', E_USER_ERROR);
            } else {
                return false;
            }
        }

        if ($this->connection) {
            if (mysql_select_db($this->config['db_database'], $this->connection)) {
                return $this->connected = true;
            } else {
                if (!$this->debug)
                    return false;
                trigger_error('Failed to open the given database!', E_USER_ERROR);
            }
        }
        $this->connected = true;
        return true;
    }

    /**
     * This is a simple function to break the connection with db server.
     */
    private function disconnect() {
        /* 	if ($this->connected) {
          mysql_close($this->connection);
          } */
    }

}

/**
 * 
 *  This class will handle the mysql querys.
 */
class mysql_stmnt {

    public $binded_sql;
    private $binds = array();
    private $connection;
    private $bind_count = 0;
    private $result = 0;
    public $debug = true;

    public function __construct($connection, $query) {
        $this->connection = $connection;
        $this->binded_sql = $query;
    }

    public function bind_params() {
        $args = func_get_args();
        $this->bind_count += func_num_args();
        $this->binds = array_merge($this->binds, $args);
    }

    public function bind_params_ex() {
        $args = func_get_args();
        $this->bind_count += func_num_args();
        $this->binds = array_merge($this->binds, $args);
        print_r($this->binds);
        exit();
    }

    public function bind_results() {
        
    }

    private function only_numbers( $input_number ) {
        if (preg_match("/^([0-9]+)$/", $input_number)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Egy sql lekérdezést készít fel és futtat paraméterek alapján. A stringben a {1} -et 'parameterre' a [1]-el siman parameterre csereli.
     * @return mysql_result
     */
    public function execute() {
        //$this->binded_sql = str_replace($this->bind_count,$this->binds,$this->binded_sql);
        $i = 0;



        /* FARM:
         * Changed parameter handling:
         * Formerly, parameters were marked with a single question mark,
         * now they are marked as numbers in brackets. This adds the ability to use a given parameter
         * more than once in the query string (for example, language tables).
         * Brackets can be either curly or square. Parameters in curly brackets are binded with
         * surrounding apostrophes, those in square brackets are not.
         */

        /* Petros
         * this is awful, performance bottleneck, and even a security hole, beacuse it does not even escape the contents
         *  this sould be written as a foreach for all parameters, collected into an array, then the replacement should happen using strtr(), which is much faster than anything one can write in php
         */
        while ($i < $this->bind_count) {
            while ($k = strpos($this->binded_sql, "{" . $i . "}")) {
                $temp = substr($this->binded_sql, 0, $k);
                //$temp .= "'" . $this->binds[$i] . "'";
                //$temp .= ( ( is_numeric($this->binds[$i]) ) ? $this->binds[$i] : "'" . $this->binds[$i] . "'" );
                $temp .= ( ( $this->only_numbers($this->binds[$i]) ) ? $this->binds[$i] : "'" . $this->binds[$i] . "'" );
                
                $temp .= substr($this->binded_sql, $k + strlen("{" . $i . "}"), strlen($this->binded_sql) - $k);
                $this->binded_sql = $temp;
            }

            while ($k = strpos($this->binded_sql, "[" . $i . "]")) {
                $temp = substr($this->binded_sql, 0, $k);
                $temp .= $this->binds[$i];
                $temp .= substr($this->binded_sql, $k + strlen("[" . $i . "]"), strlen($this->binded_sql) - $k);
                $this->binded_sql = $temp;
            }
            $i++;
        }
        /* end: FARM */

        $this->result = mysql_query($this->binded_sql, $this->connection);


        if (!$this->result) {
            if ($this->debug) {
                //trigger_error('Failed to implement mysql statement!<br />'.mysql_error()."<br />".$this->binded_sql, E_USER_ERROR);
                // @TODO eles rendszeren NEM irunk ki mysqlhibat kepernyore
                echo '<pre>' . $this->binded_sql . '</pre>';
                echo mysql_error($this->connection);
                $errno = mysql_errno($this->connection);
                if ($errno) {
                    //mail('petros@petros.hu', '[Saxon] Sql error', "Requestid: " . Request::getRequestId() . "\n\n" . mysql_errno($this->connection) . "\n\n" . mysql_error($this->connection) . "\n\n" . $this->binded_sql, "From: saxonrt@saxonrt.hu\nUser-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:8.0) Gecko/20111105 Thunderbird/8.0\nContent-Type: text/plain\n");
                    //mail('kopias.peter@gmail.com', '[Saxon] Sql error', "Requestid: " . Request::getRequestId() . "\n\n" . mysql_errno($this->connection) . "\n\n" . mysql_error($this->connection) . "\n\n" . $this->binded_sql, "From: saxonrt@saxonrt.hu\nUser-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:8.0) Gecko/20111105 Thunderbird/8.0\nContent-Type: text/plain\n");
                    print("<!-- \n\n");

                    print(Request::getRequestId() . "\n<BR>");
                    print(mysql_errno($this->connection) . "\n<BR>");
                    print(mysql_error($this->connection) . "\n<BR>");
                    print($this->binded_sql);
                    //  print_r($this->binds);
                    print("\n\n-->\n\nSql error.");
                    exit('...');
                }
            } else {
                return false;
            }
        }

        return true;
    }

    public function execute_ex() {
        $i = 0;
        while ($i < $this->bind_count) {
            while ($k = strpos($this->binded_sql, "{" . $i . "}")) {
                $temp = substr($this->binded_sql, 0, $k);
                $temp .= "'" . $this->binds[$i] . "'";
                $temp .= substr($this->binded_sql, $k + strlen("{" . $i . "}"), strlen($this->binded_sql) - $k);
                $this->binded_sql = $temp;
            }

            while ($k = strpos($this->binded_sql, "[" . $i . "]")) {
                $temp = substr($this->binded_sql, 0, $k);
                $temp .= $this->binds[$i];
                $temp .= substr($this->binded_sql, $k + strlen("[" . $i . "]"), strlen($this->binded_sql) - $k);
                $this->binded_sql = $temp;
            }
            $i++;
        }
        print($this->binded_sql . "<br />");
        $this->result = mysql_query($this->binded_sql, $this->connection);
        exit($this->binded_sql . "<br />" . mysql_error());
        if (!$this->result) {
            if ($this->debug) {
                exit($this->binded_sql . "<br />" . mysql_error());
            } else {
                return false;
            }
        }

        return true;
    }

    public function affected_rows() {
        if ($this->result) {
            $result = mysql_affected_rows($this->result);
        }
        else
            $result = false;
        return $result;
    }

    public function num_rows() {
        if ($this->result) {
            $result = mysql_num_rows($this->result);
        }
        else
            $result = false;
        return $result;
    }

    public function num_fields() {
        $result = mysql_num_fields($this->result) or false;
        return $result;
    }

    public function fetch_row($type = MYSQL_ASSOC) {
        $result = mysql_fetch_array($this->result, $type) or false;
        return $result;
    }

    public function fetch_all($type = MYSQL_ASSOC) {
        if ($this->num_rows() > 1) {
            $i = 0;
            while ($row = mysql_fetch_array($this->result, $type)) {
                $result[$i++] = $row;
            }
        } else {
            $result[0] = $this->fetch_row($type);
        }
        return $result;
    }

    public function last_query() {
        //return $this->binded_sql;
        $i = 0;
        $binded_sql = $this->binded_sql;
        while ($i < $this->bind_count) {
            while ($k = strpos($binded_sql, "{" . $i . "}")) {
                $temp = substr($binded_sql, 0, $k);
                //$temp .= ( ( is_numeric($this->binds[$i]) ) ? $this->binds[$i] : "'" . $this->binds[$i] . "'" );
                $temp .= ( ( $this->only_numbers($this->binds[$i]) ) ? $this->binds[$i] : "'" . $this->binds[$i] . "'" );
                $temp .= substr($binded_sql, $k + strlen("{" . $i . "}"), strlen($binded_sql) - $k);
                $binded_sql = $temp;
            }

            while ($k = strpos($binded_sql, "[" . $i . "]")) {
                $temp = substr($binded_sql, 0, $k);
                $temp .= $this->binds[$i];
                $temp .= substr($binded_sql, $k + strlen("[" . $i . "]"), strlen($binded_sql) - $k);
                $binded_sql = $temp;
            }
            $i++;
        }

        return $binded_sql;
    }

    public function insert_id() {
        return mysql_insert_id($this->connection);
    }

}

