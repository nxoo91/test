<?php

class Database
{
    private static $instance;
    private PDO $connexion;

    private string $DNS = 'localhost';
    private string $DBNAME = 'tp_php';
    private string $DBUSER = 'root';
    private string $DBPASS = '';

    private array $FETCHMODE = [
        0 => PDO::FETCH_ASSOC,
        1 => PDO::FETCH_OBJ
    ];

    private function __construct()
    {
        try
        {
            $opts = [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
            $this->connexion = new PDO('mysql:host='.$this->DNS.';dbname='.$this->DBNAME.';charset=utf8', $this->DBUSER, $this->DBPASS, $opts);
        }
        catch (PDOException $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public static function getInstance() 
    {
        if (is_null(self::$instance))
            self::$instance = new Database();
        return self::$instance;
    }

    protected static function protectDatas(array $datas) : array
    {
        foreach ($datas as $data)
            $data = htmlspecialchars($data);

        return $datas;
    }

    public function query(?string $query, int $fetchMode = 1) : int
    {
        if (is_null($query) || is_null(filter_var($fetchMode, FILTER_VALIDATE_INT)))
            return null;

        $req = $this->connexion->query($query);
        return $req->rowCount();
    }

    public function executeBool(?string $query, ?array $args, int $fetchMode = 1) : bool
    {
        if (is_null($query) || is_null($args) || is_null(filter_var($fetchMode, FILTER_VALIDATE_INT)))
            return false;

        $arguments = self::protectDatas($args);
        $req = $this->connexion->prepare($query);
        $req->execute($args);
        return is_null($req);
    }

    public function execute(?string $query, ?array $args, int $fetchMode = 1) : ?array
    {
        if (is_null($query) || is_null($args) || is_null(filter_var($fetchMode, FILTER_VALIDATE_INT)))
            return null;

        $arguments = self::protectDatas($args);
        $req = $this->connexion->prepare($query);
        $req->execute($arguments);
        $datas = $req->fetchAll($this->FETCHMODE[$fetchMode]);
        return $datas;
    }
}