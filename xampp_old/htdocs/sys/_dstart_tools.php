<?php

/*
 * Datastart Kft tools
 * Copyright Kopiás Péter 2011
 */

/**
 * A CFG class feladata a konfiguráció feletti irányítás megtartása, a globális változók számának csökkentése
 */
class CFG {

    /**
     * A konfiguráció egy kulcsának értékét adja vissza
     * @param string $key Ezt a kulcsot kérjük vissza a konfigurációból
     * @return mixed
     */
    public static function getVal(string $key) {
        return $GLOBALS['CFG'][$key];
    }

}

/**
 * A Stat class feladata számolni mi hányszor fut, (pl sqlquery), és ezt megjeleníteni fejlesztői kérésre
 */
class Stat {

    private static $data;

    /**
     * Számolja, hogy a $key esemény hányszor következett be (a mértékegység lehet bármi, millisectől kg-ig, nem számít)
     * @param string $key ennek a kulcsnak a mennyiseget noveljuk
     * @param float $value ennyivel noveljuk a mennyiseget
     */
    public static function increment($key,$value=1) {
        self::$data[$key]+=$value;
    }

    /**
     * Visszaadja a nyilvántartott mennyiségeket
     * @return array a mennyiségek tömbje
     */
    public static function getData() {
        return self::$data;
    }

    /**
     * Kidumpolja a mennyiségeket
     */
    public static function dumpData() {
        var_dump(self::$data);
    }

}

class Auth {

    /**
     * A bejelentkezett felhasználó azonosítóját adja vissza
     * @TODO implementálni kell
     * @return int 0
     */
    public static function getUserid() {
        return 0;
    }

}

class Request {

    private static $rid=null;

    public static function getRequestId() {
        if (!self::$rid) self::$rid=uniqid('saxonuniqid',true);
        return self::$rid;
    }

}

class Logger {
/**
 * Egy sort rögzít a naplóba, és nem dependel semmin, csak az adatbáziskapcsolaton
 * @param string $module melyik programresz idezte elo
 * @param string $message rovid hibauzenet, vagy allapotjelzes
 * @param string $messagetext reszletes hibauzenet, parameterekkel
 * @param mixed $data barmilyen adatszerkezet lehet, serializalva lesz
 * @param int $priority uzenet prioritasa
 */
    public static function log($module,$message,$messagetext=null,$data=null,$priority=100) {
        $mysql=get_connection();
        $mysql->execute('SET NAMES \'utf8\'');
        $mysql->execute('INSERT INTO `log` SET `ido`=now(),
            `module`=\''.mysql_real_escape_string($module).'\',
            `message`=\''.mysql_real_escape_string($message).'\',
            `messagetext`=\''.mysql_real_escape_string($messagetext).'\',
            `users_id`=\''.mysql_real_escape_string(Auth::getUserid()).'\',
            `requestid`=\''.mysql_real_escape_string(Request::getRequestId()).'\',
            `priority`=\''.mysql_real_escape_string($priority).'\',
            `data`=compress(\''.mysql_real_escape_string(serialize($data)).'\')');
    }

}