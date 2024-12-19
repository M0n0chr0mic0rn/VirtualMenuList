<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class MIDNIGHT
{
    private static $_db_username = 'maria';
	private static $_db_passwort = 'passwort';
	private static $_db_host = '127.0.0.1';
	private static $_db_name = 'bestellung';
	private static $_db;
    
    function __construct()
    {
        try
        {
            self::$_db = new PDO("mysql:host=" . self::$_db_host . ";dbname=" . self::$_db_name, self::$_db_username, self::$_db_passwort);

            $stmt = self::$_db->prepare("DELETE FROM Bestellung");
            $stmt->execute();
        }
        catch (\Throwable $th)
        {
            echo $th;
        }
    }
}

$midnight = new MIDNIGHT;