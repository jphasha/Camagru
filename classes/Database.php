<?php
class DataBase //a singleton class?
{
    // the underscores before the variable names are just there to denote that the variable is private.
    private static $_instance = null;//a variable that will store our instance whenever it is available.
    private $_pdo,// when a pdo object is instantiated, it will be stored in this variable for later use.
            $_query,// here we store the last query that is executed.
            $_error = false,// here there will be no change unless there is an error encountered.
            $_results,// if we were to search for 10 users from the database, they will be stored here.
            $_count = 0;// and of course, the count of the said results.

    // a constructor function that will connect to the database.
    private function __construct()
    {
        try
        {
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
            // the above line is saying: inside the private variable '$_pdo', store the PDO query to connect:
            // "new PDO('mysql:host=localhost;dbname=db_jphasha,root,password')
            // this info is accessed from the $GLOBALS variable inside the core/initialise.php file through the Config class inside the classes/config.php file.

            // now just to set the PDO error mode to Exception. (i.e.)we are trying to catch some exception.
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $some_exception)
        {
            die ("connection failed because :" . $exception->getMessage());
        }
    }

    // a function to instantiate (to create / establish)
    public static function getInstance()
    {
        if (!isset(self::$_instance))// where we have not instantiated our class:
        {
            self::$_instance = new DataBase();// we instantiate our 'DataBase' class.
        }
        return self::$_instance; //the 'getInstance()' function will instantiate our class when called upon. but only if there was no instantiation that has already occured.
    }
}
?>