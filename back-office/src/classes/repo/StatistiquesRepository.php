<?php 

namespace backoffice\admin\repo;

class StatistiquesRepository {
    protected \PDO $pdo;
    protected static ?StatistiquesRepository $instance = null;
    protected static array $config = [ ];

    protected function __construct(array $conf) {
        $this->pdo = new \PDO($conf['dsn'], $conf['user'], $conf['pass'],
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }

    public static function getInstance(){
        if (is_null(static::$instance)) {
            static::$instance = new static(self::$config);
        }
        return static::$instance;
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


    public function topInfluenceurs(int $lim) : array{
        $query = "SELECT pseudo, count(*) as nb_followers FROM Utilisateur 
                INNER JOIN Suivre ON Utilisateur.mail = Suivre.mailsuivi
                GROUP BY pseudo
                ORDER BY nb_followers
                LIMIT $lim";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $influenceurs_et_followers = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if ($influenceurs_et_followers === false) {
            return [];
        }
        return $influenceurs_et_followers;
    }

    public function tendances($lim) : array {
        $query = "SELECT libellé, count(*) as nbmentions FROM Tag 
                INNER JOIN ContenuTag ON Tag.identifiantT = ContenuTag.identifiantT
                INNER JOIN Post ON ContenuTag.numpost = Post.numpost
                GROUP BY Tag.identifiantT, libellé
                ORDER BY nbmentions ASC
                LIMIT $lim";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $tags = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if ($tags === false) {
            return [];
        }
        return $tags;
    }

}