<?php


namespace SimpleEngine\Controller;


class DatabaseController
{
    private $db;
    private static $connection = NULL;

    /**
     * @return DatabaseController
     */
    public static function connection()
    {
        if (self::$connection == NULL)
        {
            self::$connection = new self();
        }
        return self::$connection;
    }

    private function __construct()
    {
        $database = "test";
        $host = "localhost";
        $user = "root";
        $password = "";
        $this->db = new \PDO('mysql:dbname='.$database.';host='.$host.';charset=UTF8', $user, $password);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->db->query("SET NAMES utf8");
    }

    private function __clone()    { self::connection(); }
    private function __wakeup()   { self::connection(); }

    public function beginTransaction() {
        return $this->db->beginTransaction();
    }

    public function execute($params){
        return $this->db->execute($params);
    }

    public function commit() {
        return $this->db->commit();
    }

    public function rollBack() {
        return $this->db->rollBack();
    }

    public function errorInfo() {
        return $this->db->errorInfo();
    }

    public function exec($statement) {
        return $this->db->exec($statement);
    }

    public function getAttribute($attribute) {
        return $this->db->getAttribute($attribute);
    }

    public function setAttribute($attribute, $value  ) {
        return $this->db->setAttribute($attribute, $value);
    }

    public function getAvailableDrivers(){
        return $this->db->getAvailableDrivers();
    }

    public function lastInsertId($name) {
        return $this->db->lastInsertId($name);
    }

    public function query($statement) {
        return $this->db->query($statement);
    }

    public function queryFetchAllAssoc($statement) {
        return $this->db->query($statement)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function queryFetchRowAssoc($statement) {
        return $this->db->query($statement)->fetch(\PDO::FETCH_ASSOC);
    }

    public function queryFetchColAssoc($statement) {
        return $this->db->query($statement)->fetchColumn();
    }

    public function quote ($input, $parameter_type=0) {
        return $this->db->quote($input, $parameter_type);
    }

    public function getDataRowByRequest($sql, $request_data = []){
        $data = [];

        try{
            $query_handler = $this->db->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
            $query_handler->execute($request_data);

            $data = $query_handler->fetch();
        }
        catch(\Exception $e){
            echo "Error in query " . $sql . "\n";
            echo $e->getMessage()."\n";
        }

        return $data;
    }

    public function executeQuery($sql, $params=[]){
        try{
            $update_query = $this->db->prepare($sql);

            $update_query->execute($params);
        }
        catch(\Exception $e){
            echo "Error in query " . $sql . "\n";
            echo $e->getMessage()."\n";
        }
    }
}