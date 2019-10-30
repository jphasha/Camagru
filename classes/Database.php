<?php
class DB //a singleton class?
{
    // the underscores before the variable names are just there to denote that the variable is private.
    private static $_instance = null;//a variable that will store our instance whenever it is available.
    private $_pdo,// when a pdo object is instantiated, it will be stored in this variable for later use.
            $_query,// here we store the last query that is executed.
            $_error = false,// here there will be no change unless there is an error encountered.
            $_results,// if we were to search for 10 users from the database, they will be stored here.
            $_count = 0;// and of course, the count of the said results.
}
?>