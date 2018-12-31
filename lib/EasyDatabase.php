<?php
/**
 * Copyright (c) 2018. Challstrom. All Rights Reserved.
 * Used with permission by St. Edward's University
 */

/**
 * Created by IntelliJ IDEA.
 * User: tchallst
 * Date: 20-Mar-18
 * Time: 04:09 PM
 */
/*
 * This EasyDatabase class should serve most all of your Database needs. You can of course implement additional functions to add
 * additional functionality
 */

class EasyDatabase
{
    /**
     * @var mysqli
     */
    private static $database;
    /**
     * @var string
     */
    private static $databaseConfig = __DIR__ . "/database.json";

    /*
     * Basic Functions. You can use scrubQueryParam() and query() to do most everything you'll need to.
     */


    /**
     * @param string $queryParam
     * @return string
     * Removes SQL syntax from a parameter to be used in a query
     */
    public static function scrubQueryParam(string $queryParam): string
    {
        return self::getDB()->real_escape_string($queryParam);
    }

    /**
     * @return mysqli
     */
    public static function getDB(): mysqli
    {
        //casting explicitly to mysqli
        if (!self::$database) {
            self::databaseConnect();
        }
        return self::$database;
    }

    /*
     * Internal functions. Don't modify these unless you know what you're doing!
     */

    /**
     *
     */
    private static function databaseConnect()
    {
        $config = self::loadDatabaseConfig();
        self::$database = new mysqli($config['hostname'], $config['username'], $config['password'], "", $config['port']);
        if (self::$database->connect_error) {
            error_log("Database Connection Failed with " . self::$database->connect_error);
        }
        self::$database->query("USE " . $config['dbName']);
    }

    /**
     * @return array
     */
    private static function loadDatabaseConfig(): array
    {
        $databaseConfig = self::$databaseConfig;
        if (file_exists($databaseConfig)) {
            $config = json_decode(file_get_contents($databaseConfig), true);
            //print_r($config);
            if (!isset($config['hostname'])) {
                error_log("hostname not set in $databaseConfig!");
            }
            if (!isset($config['username'])) {
                error_log("username not set in $databaseConfig!");
            }
            if (!isset($config['password'])) {
                error_log("password not set in $databaseConfig!");
            }
            if (!isset($config['port'])) {
                error_log("port not set in $databaseConfig!");
            }
            if (!isset($_config['dbName'])) {
                error_log("dbName not set in $databaseConfig!");
            }
            return $config;
        } else {
            file_put_contents($databaseConfig, '{
  "hostname": "localhost",
  "username": "user",
  "password": "password",
  "port": "3306",
  "dbName": "database"
}');
            error_log("Database config file not found! A default config file has been created at $databaseConfig!");
        }
        return [];
    }
    /**
     * @param string $query
     * @return array
     * Takes in a SQL query as a string, queries the database, returns the resulting rows as a single array or array of arrays
     */
    public static function query(string $query): array
    {
        $result = self::getDB()->query($query);
        if (self::getDB()->error) {
            error_log("Query $query FAILED with " . self::getDB()->error);
        } else if ($result) {
            switch ($result->num_rows) {
                case 0:
                    return [];
                    break;
                case 1:
                    return $result->fetch_assoc();
                default:
                    $data = [];
                    while ($row = $result->fetch_assoc()) {
                        array_push($data, $row);
                    }
                    return $data;
            }
        }
        error_log("Result could not be constructed in EasyDatabase.query() with query $query");
        return [];
    }
}