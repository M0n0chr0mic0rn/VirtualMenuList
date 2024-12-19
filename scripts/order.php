<?php

class BESTELLUNG {
    private static $_db_username = 'maria';     // This user is a local user
    private static $_db_passwort = 'passwort';  // Dont waste your time trying to get access
    private static $_db_host = '127.0.0.1';
    private static $_db_name = 'bestellung';
    private static $_db;
    
    function __construct() {
        try {
            self::$_db = new PDO('mysql:host=' . self::$_db_host . ';dbname=' . self::$_db_name, self::$_db_username, self::$_db_passwort);
        } catch(PDOException $e) {
            echo '<br>DATABASE ERROR<br>'.$e;
            die();
        }
    }

    private function createID()
    {
        $loop = true;

        do
        {
            $ID = '';

            for ($a=0; $a < 4; $a++)
            { 
                $z = rand(0,35);

                switch ($z)
                {
                    case 0: $ID .= '0'; break;
                    case 1: $ID .= '1'; break;
                    case 2: $ID .= '2'; break;
                    case 3: $ID .= '3'; break;
                    case 4: $ID .= '4'; break;
                    case 5: $ID .= '5'; break;
                    case 6: $ID .= '6'; break;
                    case 7: $ID .= '7'; break;
                    case 8: $ID .= '8'; break;
                    case 9: $ID .= '9'; break;
                    case 10: $ID .= 'a'; break;
                    case 11: $ID .= 'b'; break;
                    case 12: $ID .= 'c'; break;
                    case 13: $ID .= 'd'; break;
                    case 14: $ID .= 'e'; break;
                    case 15: $ID .= 'f'; break;
                    case 16: $ID .= 'g'; break;
                    case 17: $ID .= 'h'; break;
                    case 18: $ID .= 'i'; break;
                    case 19: $ID .= 'j'; break;
                    case 20: $ID .= 'k'; break;
                    case 21: $ID .= 'l'; break;
                    case 22: $ID .= 'm'; break;
                    case 23: $ID .= 'n'; break;
                    case 24: $ID .= 'o'; break;
                    case 25: $ID .= 'p'; break;
                    case 26: $ID .= 'q'; break;
                    case 27: $ID .= 'r'; break;
                    case 28: $ID .= 's'; break;
                    case 29: $ID .= 't'; break;
                    case 30: $ID .= 'u'; break;
                    case 31: $ID .= 'v'; break;
                    case 32: $ID .= 'x'; break;
                    case 33: $ID .= 'x'; break;
                    case 34: $ID .= 'y'; break;
                    case 35: $ID .= 'z'; break;
                }
            }

            $stmt = self::$_db->prepare("SELECT * FROM Bestellung WHERE ID=:id");
            $stmt->bindParam(':id', $ID);
            $stmt->execute();
            if ($stmt->rowCount() == 0) $loop = false;
        }
        while($loop);
        
        return $ID;
    }

    private function createAuth() {
        $auth = '';

        for ($a=0; $a < 500; $a++) { 
            $b = rand(0,35);

            switch ($b) {
                case 0: $auth .= '0'; break;
                case 1: $auth .= '1'; break;
                case 2: $auth .= '2'; break;
                case 3: $auth .= '3'; break;
                case 4: $auth .= '4'; break;
                case 5: $auth .= '5'; break;
                case 6: $auth .= '6'; break;
                case 7: $auth .= '7'; break;
                case 8: $auth .= '8'; break;
                case 9: $auth .= '9'; break;
                case 10: $auth .= 'a'; break;
                case 11: $auth .= 'b'; break;
                case 12: $auth .= 'c'; break;
                case 13: $auth .= 'd'; break;
                case 14: $auth .= 'e'; break;
                case 15: $auth .= 'f'; break;
                case 16: $auth .= 'g'; break;
                case 17: $auth .= 'h'; break;
                case 18: $auth .= 'i'; break;
                case 19: $auth .= 'j'; break;
                case 20: $auth .= 'k'; break;
                case 21: $auth .= 'l'; break;
                case 22: $auth .= 'm'; break;
                case 23: $auth .= 'n'; break;
                case 24: $auth .= 'o'; break;
                case 25: $auth .= 'p'; break;
                case 26: $auth .= 'q'; break;
                case 27: $auth .= 'r'; break;
                case 28: $auth .= 's'; break;
                case 29: $auth .= 't'; break;
                case 30: $auth .= 'u'; break;
                case 31: $auth .= 'v'; break;
                case 32: $auth .= 'x'; break;
                case 33: $auth .= 'x'; break;
                case 34: $auth .= 'y'; break;
                case 35: $auth .= 'z'; break;
            }
        }
        return $auth;
    }

    function login($user, $pass)
    {
        $username = '<your vendor username>';
        $password = '<your static, superlong and cryptic password for vendor login>';
        
        $return = array();
        $return['answer'] = 'Login failed';
        $return['bool'] = false;

        if ($user === $username && $pass === $password)
        {
            $key = self::createAuth();

            $stmt = self::$_db->prepare('DELETE FROM Auth');
            $stmt->execute();
            $stmt->errorInfo();

            $stmt = self::$_db->prepare('INSERT INTO Auth (authkey) VALUES (:authkey)');
            $stmt->bindParam(':authkey', $key);
            $stmt->execute();

            $return['answer'] = 'Login done';
            $return['bool'] = true;
            $return['auth'] = $key;
        } 

        return $return;
    }

    function createOrder($content) {
        $json = array();
        $ID = self::createID();

        $stmt = self::$_db->prepare('SELECT * FROM Bestellung WHERE ID=:id');
        $stmt->bindParam(':id', $ID);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            $stmt = self::$_db->prepare('INSERT INTO Bestellung (ID, Content) VALUES (:id, :content)');
            $stmt->bindParam(':id', $ID);
            $stmt->bindParam(':content', $content);
            $stmt->execute();

            $json['antwort'] = 'Bestellung erstellt';
            $json['bool'] = true;
            $json['id'] = $ID;
        } else {
            $json['antwort'] = 'Bestellung konnte nicht erstellt werden';
            $json['bool'] = false;
        }

        echo json_encode($json, JSON_PRETTY_PRINT);
    }

    function abortOrder($ID) {
        $json = array();
        $status = -1;

        $stmt = self::$_db->prepare('SELECT Status FROM Bestellung WHERE ID=:id');
        $stmt->bindParam(':id', $ID);
        $stmt->execute();
        $dbStatus = $stmt->fetch()['Status'];
        if ($stmt->rowCount() === 1) {
            if ($dbStatus === 0) {
                $stmt = self::$_db->prepare('UPDATE Bestellung SET Status=:status WHERE ID=:id');
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':id', $ID);
                $stmt->execute();

                $json['antwort'] = 'Bestellung wurde abgebrochen';
                $json['bool'] = true;
            } else {
                $json['antwort'] = 'Abbruch fehlgeschlagen';
                $json['bool'] = false;
            }

            echo json_encode($json, JSON_PRETTY_PRINT);
        }
    }

    function updateOrder($ID, $content) {
        $json = array();
        $status = 0;

        $stmt = self::$_db->prepare('SELECT Status FROM Bestellung WHERE ID=:id');
        $stmt->bindParam(':id', $ID);
        $stmt->execute();
        $dbStatus = $stmt->fetch()['Status'];
        if ($stmt->rowCount() === 1) {
            if ($dbStatus === 0) {
                $stmt = self::$_db->prepare('UPDATE Bestellung SET Content=:content WHERE ID=:id AND Status=:status');
                $stmt->bindParam(':content', $content);
                $stmt->bindParam(':id', $ID);
                $stmt->bindParam(':status', $status);
                $stmt->execute();

                $json['antwort'] = 'Bestellung wurde aktualisiert';
                $json['bool'] = true;
            } else {
                $json['antwort'] = 'Aktualisierung fehlgeschlagen';
                $json['bool'] = false;
            }

            echo json_encode($json, JSON_PRETTY_PRINT);
        }
    }

    function sendOrder($content, $customer)
    {
        $ID = self::createID();
        $status = 0;
        $time = time();

        $stmt = self::$_db->prepare("INSERT INTO Bestellung (ID, Type, Content, Status, Name, Address, Tele, Zusatz, IP, Time) VALUES (:ID, :Type, :Content, :Status, :Name, :Address, :Tele, :Zusatz, :IP, :Time)");
        $stmt->bindParam(':ID', $ID);
        $stmt->bindParam(':Type', $customer->type);
        $stmt->bindParam(':Content', $content);
        $stmt->bindParam(':Status', $status);
        $stmt->bindParam(':Name', $customer->name);
        $stmt->bindParam(':Address', $customer->address);
        $stmt->bindParam(':Tele', $customer->tele);
        $stmt->bindParam(':Zusatz', $customer->zusatz);
        $stmt->bindParam(':IP', $_SERVER["REMOTE_ADDR"]);
        $stmt->bindParam(':Time', $time);
        $stmt->execute();
        if ($stmt->rowCount() == 1) 
        {
            $return = (object)array();
            $return->answer = "Bestellung erfolgreich angenommen";
            $return->id = $ID;
            $return->bool = true;
        }
        else
        {
            $return = (object)array();
            $return->answer = "Bestellung fehlgeschlagen";
            $return->bool = false;
        }

        echo json_encode($return, JSON_PRETTY_PRINT);
    }

    function getOrders() {
        $status = 0;
        
        $stmt = self::$_db->prepare('SELECT * FROM Bestellung WHERE Status=:status');
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getOrderStat($ID)
    {
        $stmt = self::$_db->prepare('SELECT * FROM Bestellung WHERE ID=:id');
        $stmt->bindParam(':id', $ID);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function print($ID)
    {
        $status = 0;
        $newstatus = 1;

        $stmt = self::$_db->prepare('SELECT Status FROM Bestellung WHERE ID=:id AND Status=:status');
        $stmt->bindParam(':id', $ID);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        if ($stmt->rowCount() === 1) {
            $stmt = self::$_db->prepare('UPDATE Bestellung SET Status=:status WHERE ID=:id');
            $stmt->bindParam(':status', $newstatus);
            $stmt->bindParam(':id', $ID);
            $stmt->execute();
        }
    }
}