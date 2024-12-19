<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class IPUPDATE
{
    private static $_db_username = 'maria';     // This user is a local user
	private static $_db_passwort = 'passwort';  // Dont waste your time trying to get access
	private static $_db_host = '127.0.0.1';
	private static $_db_name = 'server';
	private static $_db;
    
    function __construct()
    {
        try
        {
            self::$_db = new PDO("mysql:host=" . self::$_db_host . ";dbname=" . self::$_db_name, self::$_db_username, self::$_db_passwort);

            $stmt = self::$_db->prepare("SELECT * FROM IP");
            $stmt->execute();
            $dbIP = $stmt->fetch()[0];

            $myIP = shell_exec('dig +short myip.opendns.com @resolver1.opendns.com');
            //var_dump($myIP);
            $myIP = str_replace(array("\r", "\n"), '', $myIP);

            $host = "subdomain, use '@' for toplevel";
            $domain = "<your domain>";
            $password = "your API password from your domain provider";

            if ($myIP != $dbIP)
            {
                try
                {
                    // The base URL may be diffrent to you if you use another Domain Provider
                    $url = 'https://dynamicdns.park-your-domain.com/update?host='.$host.'&domain='.$domain.'&password='.$password.'&ip='.$myIP;
                    $xml = file_get_contents($url);

                    $stmt = self::$_db->prepare("UPDATE IP SET IP=:ip");
                    $stmt->bindParam(":ip", $myIP);
                    $stmt->execute();
                }
                catch (\Throwable $th)
                {
                    echo $th;
                }
            }
        }
        catch (\Throwable $th)
        {
            echo $th;
        }
    }
}
$ipupdate = new IPUPDATE;