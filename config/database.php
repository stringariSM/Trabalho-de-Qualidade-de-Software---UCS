<?php
class Database {
    private $db;
    private $resource;

    public function __construct(){
        $this->db = $this->db_connect();
    }

    private function db_connect()
    {
        $config =array(
            'hostname' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'aula_qualidade',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'port'     => 3306
        );;

        $mysqli = mysqli_init();
        $mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10);
        $mysqli->options(MYSQLI_INIT_COMMAND, 'SET SESSION sql_mode = CONCAT(@@sql_mode, ",", "STRICT_ALL_TABLES")');
        $mysqli->options(MYSQLI_INIT_COMMAND,
            'SET SESSION sql_mode =
            REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
            @@sql_mode,
            "STRICT_ALL_TABLES,", ""),
            ",STRICT_ALL_TABLES", ""),
            "STRICT_ALL_TABLES", ""),
            "STRICT_TRANS_TABLES,", ""),
            ",STRICT_TRANS_TABLES", ""),
            "STRICT_TRANS_TABLES", "")'
        );

        if ($mysqli->real_connect($config['hostname'], $config['username'], $config['password'], $config['database'], $config['port']))
        {
            $mysqli->set_charset('utf8');
            $mysqli->query("SET collation_connection = ".$config['dbcollat']);
            $mysqli->query("SET lc_time_names= 'pt_BR'");
            $mysqli->query("SET SESSION group_concat_max_len = 1000000");

            return $mysqli;
        }

        die($mysqli->error);
        return FALSE;
    }

    public function query($querySQL){
        $result = mysqli_query($this->db, $querySQL) or die(mysqli_error($this->db));
        $this->resource = $result;

        $obj = [];
        while ($row = mysqli_fetch_assoc($this->resource)) {
            $obj[] = (Object)$row;
        }

        if(count($obj) == 1){
            $obj = $obj[0];
        }

        return $obj;
    }

    public function delete($table, $id){
        $result = mysqli_query($this->db, "DELETE FROM `$table` WHERE id = $id") or die(mysqli_error($this->db));
        return $result;
    }

    public function last_insert_id()
    {
        return mysqli_insert_id($this->db);
    }

    public function num_rows()
    {
        return mysqli_num_rows($this->resource);
    }

    public function escape($str)
    {
        return str_replace("'", "''", $this->remove_invisible_characters($str, FALSE));
    }

    private function remove_invisible_characters($str, $url_encoded = TRUE)
    {
        $non_displayables = array();

        if ($url_encoded)
        {
            $non_displayables[] = '/%0[0-8bcef]/';  // url encoded 00-08, 11, 12, 14, 15
            $non_displayables[] = '/%1[0-9a-f]/';   // url encoded 16-31
        }

        $non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';   // 00-08, 11, 12, 14-31, 127

        do
        {
            $str = preg_replace($non_displayables, '', $str, -1, $count);
        }
        while ($count);

        return $str;
    }

    public function update( string $table, array $variables = array(), array $where = array(), $limit = '' ) :bool
    {
        if( empty( $variables ) )
        {
            return false;
        }
        $sql = "UPDATE ". $table ." SET ";
        foreach( $variables as $field => $value )
        {
            if($this->_has_operator($value)){
                $updates[] = "`$field` = $value";
            }else{
                $updates[] = "`$field` = '$value'";
            }
        }
        $sql .= implode(', ', $updates);

        //Add the $where clauses as needed
        if( !empty( $where ) )
        {
            foreach( $where as $field => $value )
            {
                $value = $value;
                $clause[] = "`$field` = '$value'";
            }
            $sql .= ' WHERE '. implode(' AND ', $clause);
        }

        if( !empty( $limit ) )
        {
            $sql .= ' LIMIT '. $limit;
        }

        $this->resource = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        return (bool) $this->resource;
    }

    private function _has_operator($str)
    {
        return (bool) preg_match('/GeomFromText|\bDATE_ADD\b|\bCURDATE\b|\bnow()\b/i', trim($str));
    }

    public function insert( $table, $variables = array() ) : bool
    {
        //Make sure the array isn't empty
        if( empty( $variables ) )
        {
            return false;
        }

        $sql = "INSERT INTO ". $table;
        $fields = array();
        $values = array();
        foreach( $variables as $field => $value )
        {
            $fields[] = $field;

            if($this->_has_operator($value)){
                $values[] = $value;
            }else{
                $values[] = "'".$value."'";
            }
        }
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = '('. implode(', ', $values) .')';

        $sql .= $fields .' VALUES '. $values;
// echo '<pre>';die(var_dump($sql));
        $this->resource = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        return (bool) $this->resource;
    }

}