<?PHP

namespace libs;
use \PDO;

class Db
{
	public $pdo;
	
	function __construct()
	{
		$this->pdo = $this->connect(DB, USER, PASSWORD, HOST);
	}
	
	private function connect( $db, $login, $passwd, $host )
	{
		$dsn = "mysql:host=" . $host . 
        ";dbname=" . $db . ";charset=utf8";
        $opt= [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES  => true
        ];
        try
        {
            $pdo = new PDO( $dsn, $login, $passwd, $opt );
        }
        catch(PDOException $e) 
        {  
            $pdo = $e->getMessage();
        }
		return $pdo;
	}
	
	// after query return u can use "$someResult = $stmt->fetchAll();" if SELECT
	public function query( $sqlString, $arrayParams = [] )
	{	
		$stmt = $this->pdo->prepare( $sqlString );
		$stmt->execute( $arrayParams );
		return $stmt;
	}
	
}