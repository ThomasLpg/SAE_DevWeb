<?php
namespace iutnc\iks\repo;

//Reprit des TD de cours

class IksRepository {
    protected \PDO $pdo;
    protected static ?IksRepository $instance = null;
    protected static array $config = [ ];

    protected function __construct(array $conf) {
        $this->pdo = new \PDO($conf['dsn'], $conf['user'], $conf['pass'],
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }

    public static function getInstance(){
        if (is_null(self::$instance)) {
            self::$instance = new static(self::$config);
        }
        return self::$instance;
    }

    public static function setConfig(string $file) {
        $conf = parse_ini_file($file);
        if ($conf === false) {
            throw new \Exception("Error reading configuration file");
        }
        self::$config = [ 'dsn'=> "{$conf['driver']}:host={$conf['host']};dbname={$conf['database']}",
                            'user'=> $conf['username'],
                            'pass'=> $conf['password'] ];
    }

}